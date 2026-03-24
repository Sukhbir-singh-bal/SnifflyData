<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rawApiKey = $request->header('x-api-key');

        if (! $rawApiKey) {
            return $this->unauthorizedResponse('API key is required.');
        }

        $hashedApiKey = hash('sha256', $rawApiKey);

        $apiKey = ApiKey::query()
            ->with('user')
            ->where('key_hash', $hashedApiKey)
            ->first();

        if (! $apiKey) {
            return $this->unauthorizedResponse('Invalid API key.');
        }

        if ($apiKey->usage_count >= $apiKey->usage_limit) {
            return response()->json([
                'message' => 'API key usage limit exceeded.',
            ], 429);
        }

        $apiKey->increment('usage_count');

        $request->setUserResolver(fn () => $apiKey->user);
        $request->attributes->set('apiKey', $apiKey);

        return $next($request);
    }

    private function unauthorizedResponse(string $message): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], 401);
    }
}
