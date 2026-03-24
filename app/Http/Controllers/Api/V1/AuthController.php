<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\ApiKeyResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Support\ApiKeyGenerator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register and issue Sanctum token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        event(new Registered($user));

        $generatedApiKey = ApiKeyGenerator::generate();

        $apiKey = $user->apiKeys()->create([
            'key_hash' => $generatedApiKey['hash'],
            'key_last4' => $generatedApiKey['last4'],
            'name' => 'Default Key',
            'usage_limit' => 100000,
            'usage_count' => 0,
        ]);

        $token = $user->createToken($request->input('device_name', 'api-client'))->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'token' => $token,
            'user' => new UserResource($user->load('apiKeys')),
            'api_key' => new ApiKeyResource($apiKey),
            'plain_text_api_key' => $generatedApiKey['plain'],
        ], 201);
    }

    /**
     * Login and issue Sanctum token.
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::query()->where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive. Please contact support.'],
            ]);
        }

        $token = $user->createToken($request->input('device_name', 'api-client'))->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => new UserResource($user->load('apiKeys')),
        ]);
    }

    /**
     * Return authenticated user profile.
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()->load('apiKeys')),
        ]);
    }

    /**
     * Revoke current token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }
}
