<?php

namespace App\Jobs;

use App\Models\ScrapeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ScrapeWebsiteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Max HTTP attempts per job (independent from queue retry settings).
     */
    private const MAX_ATTEMPTS = 3;
    private const HTTP_TIMEOUT_SECONDS = 10;

    public function __construct(
        public readonly string $url,
        public readonly int $apiKeyId,
        public readonly int $requestId
    ) {}

    public function handle(): void
    {
        $serviceUrl = env('SCRAPER_SERVICE_URL', 'http://localhost:3000/scrape');

        $lastFailure = null;

        for ($attempt = 1; $attempt <= self::MAX_ATTEMPTS; $attempt++) {
            $startedAt = microtime(true);

            try {
                $response = Http::timeout(self::HTTP_TIMEOUT_SECONDS)
                    ->post($serviceUrl, [
                        'url' => $this->url,
                    ]);

                $elapsedMs = (int) round((microtime(true) - $startedAt) * 1000);

                $body = $response->json();
                $success = (bool) ($body['success'] ?? false);
                $statusCode = (int) ($body['status_code'] ?? $response->status());
                $error = $body['error'] ?? null;

                if ($success && $statusCode === 200) {
                    ScrapeRequest::query()
                        ->whereKey($this->requestId)
                        ->update([
                            'status' => ScrapeRequest::STATUS_SUCCESS,
                            'response_time' => $elapsedMs,
                            'credits_used' => 1,
                        ]);

                    Log::info('Scrape succeeded', [
                        'request_id' => $this->requestId,
                        'api_key_id' => $this->apiKeyId,
                        'attempt' => $attempt,
                        'elapsed_ms' => $elapsedMs,
                    ]);

                    return;
                }

                $httpStatus = $response->status();
                $failure = [
                    'success' => $success,
                    'http_status' => $httpStatus,
                    'service_status_code' => $statusCode,
                    'error' => $error,
                    'response_body' => $body,
                    'elapsed_ms' => $elapsedMs,
                ];

                $lastFailure = $failure;

                $retryable = $this->isRetryableFailure($error, $httpStatus);
                Log::warning('Scrape failed (will' . ($retryable && $attempt < self::MAX_ATTEMPTS ? ' retry' : ' not retry') . ')', [
                    'request_id' => $this->requestId,
                    'api_key_id' => $this->apiKeyId,
                    'attempt' => $attempt,
                    'elapsed_ms' => $elapsedMs,
                    'error' => $error,
                    'http_status' => $httpStatus,
                ]);

                if (! $retryable || $attempt >= self::MAX_ATTEMPTS) {
                    break;
                }

                // Small delay between retries for transient failures.
                usleep(250_000);
            } catch (Throwable $e) {
                $elapsedMs = (int) round((microtime(true) - $startedAt) * 1000);
                $lastFailure = [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'elapsed_ms' => $elapsedMs,
                ];

                $retryable = $this->isRetryableException($e);

                Log::error('Scrape request exception', [
                    'request_id' => $this->requestId,
                    'api_key_id' => $this->apiKeyId,
                    'attempt' => $attempt,
                    'elapsed_ms' => $elapsedMs,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'retryable' => $retryable,
                ]);

                if (! $retryable || $attempt >= self::MAX_ATTEMPTS) {
                    break;
                }

                // Small delay between retries for transient failures.
                usleep(250_000);
            }
        }

        // Final failure: mark the request as failed.
        ScrapeRequest::query()
            ->whereKey($this->requestId)
            ->update([
                'status' => ScrapeRequest::STATUS_FAILED,
                // Keep `credits_used` as-is (defaults to 0), and don't overwrite response_time unless desired.
            ]);

        Log::warning('Scrape finalized as failed', [
            'request_id' => $this->requestId,
            'api_key_id' => $this->apiKeyId,
            'last_failure' => $lastFailure,
        ]);
    }

    private function isRetryableException(Throwable $e): bool
    {
        return $e instanceof \Illuminate\Http\Client\ConnectionException
            || $e instanceof \Illuminate\Http\Client\RequestException;
    }

    private function isRetryableFailure(?string $error, ?int $httpStatus): bool
    {
        if ($error === 'timeout' || $error === 'internal_error') {
            return true;
        }

        if ($httpStatus === null) {
            return true;
        }

        return in_array($httpStatus, [408, 429, 500, 502, 503, 504], true);
    }
}
