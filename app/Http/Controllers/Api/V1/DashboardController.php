<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScrapeRequestResource;
use App\Models\ScrapeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $aggregates = ScrapeRequest::query()
            ->where('user_id', $userId)
            ->selectRaw('COUNT(*) as total_requests')
            ->selectRaw("SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as success_requests", [ScrapeRequest::STATUS_SUCCESS])
            ->selectRaw("SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as failed_requests", [ScrapeRequest::STATUS_FAILED])
            ->selectRaw('COALESCE(SUM(credits_used), 0) as credits_used')
            ->first();

        $total = (int) ($aggregates?->total_requests ?? 0);
        $success = (int) ($aggregates?->success_requests ?? 0);
        $failed = (int) ($aggregates?->failed_requests ?? 0);
        $creditsUsed = (int) ($aggregates?->credits_used ?? 0);
        $successRate = $total > 0 ? round(($success / $total) * 100, 2) : 0.0;

        return response()->json([
            'total_requests' => $total,
            'success_rate' => $successRate,
            'failed_requests' => $failed,
            'credits_used' => $creditsUsed,
        ]);
    }

    public function recentRequests(Request $request): JsonResponse
    {
        $recentRequests = ScrapeRequest::query()
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => ScrapeRequestResource::collection($recentRequests),
        ]);
    }
}
