<?php

use App\Http\Controllers\Api\V1\ApiKeyController;
use App\Http\Controllers\Api\V1\AdminUserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'active.user'])->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::get('/api-keys', [ApiKeyController::class, 'index']);
        Route::post('/api-keys/generate', [ApiKeyController::class, 'generate']);
        Route::delete('/api-keys/{id}', [ApiKeyController::class, 'destroy']);
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::patch('/profile', [ProfileController::class, 'update']);
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        Route::get('/dashboard/recent-requests', [DashboardController::class, 'recentRequests']);

        Route::prefix('admin')->middleware('role:admin')->group(function (): void {
            Route::get('/users', [AdminUserController::class, 'index']);
            Route::patch('/users/{id}/status', [AdminUserController::class, 'updateStatus']);
        });
    });
});
