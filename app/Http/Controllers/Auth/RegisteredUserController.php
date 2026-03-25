<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ApiKeyGenerator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        $generatedApiKey = ApiKeyGenerator::generate();

        $user->apiKeys()->create([
            'key_hash' => $generatedApiKey['hash'],
            'key_last4' => $generatedApiKey['last4'],
            'name' => 'Default Key',
            'usage_limit' => 100000,
            'usage_count' => 0,
        ]);

        Auth::login($user);

        $request->session()->put('new_api_key', $generatedApiKey['plain']);
        $request->session()->put('status', 'Account created successfully.');

        return redirect()->route('dashboard');
    }
}
