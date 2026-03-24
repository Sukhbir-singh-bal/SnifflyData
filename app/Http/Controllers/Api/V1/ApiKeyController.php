<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GenerateApiKeyRequest;
use App\Http\Resources\Api\V1\ApiKeyResource;
use App\Support\ApiKeyGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $keys = $request->user()
            ->apiKeys()
            ->latest('id')
            ->get();

        return response()->json([
            'data' => ApiKeyResource::collection($keys),
        ]);
    }

    public function generate(GenerateApiKeyRequest $request): JsonResponse
    {
        $user = $request->user();

        $generatedApiKey = ApiKeyGenerator::generate();

        $apiKey = $user->apiKeys()->create([
            'key_hash' => $generatedApiKey['hash'],
            'key_last4' => $generatedApiKey['last4'],
            'name' => $request->input('name', 'Default Key'),
            'usage_limit' => $request->integer('usage_limit', 100000),
            'usage_count' => 0,
        ]);

        return response()->json([
            'message' => 'API key generated successfully.',
            'api_key' => new ApiKeyResource($apiKey),
            'plain_text_api_key' => $generatedApiKey['plain'],
        ], 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $apiKey = $request->user()->apiKeys()->findOrFail($id);
        $apiKey->delete();

        return response()->json([
            'message' => 'API key deleted successfully.',
        ]);
    }
}
