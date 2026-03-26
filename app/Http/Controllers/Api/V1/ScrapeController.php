<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreScrapeRequest;
use App\Models\ApiKey;
use App\Models\ScrapeRequest;
use App\Jobs\ScrapeWebsiteJob;
use App\Http\Resources\Api\V1\ScrapeRequestResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{
    public function store(StoreScrapeRequest $request): JsonResponse
    {
        /** @var ApiKey|null $apiKey */
        $apiKey = $request->attributes->get('apiKey');
        if (! $apiKey) {
            // Should be unreachable if `api.key` middleware is applied.
            abort(401, 'Invalid API key.');
        }

        // Strictly accept 'url' only
        $url = $request->validated('url');

        $scrapeRequest = ScrapeRequest::create([
            'user_id' => $apiKey->user_id,
            'api_key_id' => $apiKey->id,
            'url' => $url,
            'status' => ScrapeRequest::STATUS_PENDING,
        ]);

        ScrapeWebsiteJob::dispatch(
            $url,
            $apiKey->id,
            $scrapeRequest->id
        );

        return response()->json([
            'request_id' => $scrapeRequest->id,
            'status' => ScrapeRequest::STATUS_PENDING,
        ], 202);
    }

    public function show($id, Request $request): ScrapeRequestResource
    {
        /** @var ApiKey|null $apiKey */
        $apiKey = $request->attributes->get('apiKey');
        if (! $apiKey) {
            abort(401, 'Invalid API key.');
        }

        $scrapeRequest = ScrapeRequest::where('user_id', $apiKey->user_id)
            ->findOrFail($id);

        return new ScrapeRequestResource($scrapeRequest);
    }
}
