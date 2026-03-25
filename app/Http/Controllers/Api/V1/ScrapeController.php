<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Scraping\CreateScrapeRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreScrapeRequest;
use App\Models\ApiKey;
use Illuminate\Http\JsonResponse;

class ScrapeController extends Controller
{
    public function store(
        StoreScrapeRequest $request,
        CreateScrapeRequestAction $createScrapeRequestAction
    ): JsonResponse {
        /** @var ApiKey|null $apiKey */
        $apiKey = $request->attributes->get('apiKey');
        if (! $apiKey) {
            // Should be unreachable if `api.key` middleware is applied.
            abort(401, 'Invalid API key.');
        }

        $scrapeRequest = $createScrapeRequestAction->execute(
            $apiKey,
            $request->string('url')->toString(),
        );

        return response()->json([
            'request_id' => $scrapeRequest->id,
        ], 202);
    }
}
