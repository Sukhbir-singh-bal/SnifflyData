<?php

namespace App\Application\Scraping;

use App\Jobs\ScrapeWebsiteJob;
use App\Models\ScrapeRequest;
use App\Models\User;

class CreateScrapeRequestAction
{
    public function execute(User $user, string $url, int $apiKeyId): ScrapeRequest
    {
        $scrapeRequest = ScrapeRequest::query()->create([
            'user_id' => $user->id,
            'api_key_id' => $apiKeyId,
            'url' => $url,
            'status' => ScrapeRequest::STATUS_PENDING,
        ]);

        ScrapeWebsiteJob::dispatch($url, $apiKeyId, $scrapeRequest->id)
            ->onQueue('scraping');

        return $scrapeRequest;
    }
}
