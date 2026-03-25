<?php

namespace App\Application\Scraping;

use App\Jobs\ScrapeWebsiteJob;
use App\Models\ApiKey;
use App\Models\ScrapeRequest;

class CreateScrapeRequestAction
{
    public function execute(ApiKey $apiKey, string $url): ScrapeRequest
    {
        $scrapeRequest = ScrapeRequest::query()->create([
            'user_id' => $apiKey->user_id,
            'api_key_id' => $apiKey->id,
            'url' => $url,
            'status' => ScrapeRequest::STATUS_PENDING,
        ]);

        ScrapeWebsiteJob::dispatch($url, $apiKey->id, $scrapeRequest->id)
            ->onQueue('scraping');

        return $scrapeRequest;
    }
}
