<?php

namespace App\Http\Controllers;

use App\Support\ApiKeyGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ScrapeRequest;

class UserDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $totalRequests = $user->requests()->count();
        $totalCredits = $user->requests()->sum('credits_used');
        $recentRequests = $user->requests()->with('apiKey')->latest('id')->take(5)->get();
        $activeKeysCount = $user->apiKeys()->count();

        return view('dashboard.overview', [
            'totalRequests' => $totalRequests,
            'totalCredits' => $totalCredits,
            'recentRequests' => $recentRequests,
            'activeKeysCount' => $activeKeysCount,
        ]);
    }

    public function apiKeys(Request $request): View
    {
        $user = $request->user();
        $apiKeys = $user->apiKeys()->latest('id')->get();

        return view('dashboard.api-keys', [
            'apiKeys' => $apiKeys,
            'newApiKey' => $request->request->get('new_api_key') ?? $request->session()->pull('new_api_key'),
            'status' => $request->session()->pull('status'),
        ]);
    }

    public function generateApiKey(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $generatedApiKey = ApiKeyGenerator::generate();

        $request->user()->apiKeys()->create([
            'key_hash' => $generatedApiKey['hash'],
            'key_last4' => $generatedApiKey['last4'],
            'name' => $validated['name'],
            'usage_limit' => 100000,
            'usage_count' => 0,
        ]);

        return redirect()
            ->route('dashboard.api-keys')
            ->with('status', 'A new API key has been generated.')
            ->with('new_api_key', $generatedApiKey['plain']);
    }

    public function requests(Request $request): View
    {
        $status = $request->query('status');
        $query = $request->user()->requests()->with('apiKey')->latest('id');

        if ($status && in_array($status, ['pending', 'success', 'failed'])) {
            $query->where('status', $status);
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('dashboard.requests', [
            'requests' => $requests,
            'currentStatus' => $status,
        ]);
    }

    public function requestStatus(Request $request, ScrapeRequest $scrapeRequest): JsonResponse
    {
        abort_if($scrapeRequest->user_id !== $request->user()->id, 403);

        return response()->json([
            'status' => $scrapeRequest->status,
            'response_time' => $scrapeRequest->response_time ? $scrapeRequest->response_time . 'ms' : '-',
            'credits_used' => $scrapeRequest->credits_used,
        ]);
    }

    public function usage(Request $request): View
    {
        $user = $request->user();
        
        $totalRequests = $user->requests()->count();
        $totalCredits = $user->requests()->sum('credits_used');
        $avgResponseTime = (int) $user->requests()->where('status', 'success')->avg('response_time');
        
        return view('dashboard.usage', [
            'totalRequests' => $totalRequests,
            'totalCredits' => $totalCredits,
            'avgResponseTime' => $avgResponseTime,
            'apiKeys' => $user->apiKeys()->withCount('requests')->get(),
        ]);
    }

    public function playground(Request $request): View
    {
        return view('dashboard.playground', [
            'apiKeys' => $request->user()->apiKeys()->latest('id')->get()
        ]);
    }
}
