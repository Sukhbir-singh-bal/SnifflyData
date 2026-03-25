<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Scraping\CreateScrapeRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreScrapeRequest;
use Illuminate\Http\JsonResponse;

class ScrapeController extends Controller
{
    public function store(
        StoreScrapeRequest $request,
        CreateScrapeRequestAction $createScrapeRequestAction
    ): JsonResponse {
        $scrapeRequest = $createScrapeRequestAction->execute(
            $request->user(),
            $request->string('url')->toString(),
            $request->integer('api_key_id')
        );

        return response()->json([
            'request_id' => $scrapeRequest->id,
        ], 202);
    }
}
