<?php

use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function (): void {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/api-keys', [UserDashboardController::class, 'apiKeys'])->name('dashboard.api-keys');
    Route::post('/dashboard/api-keys/generate', [UserDashboardController::class, 'generateApiKey'])->name('dashboard.api-keys.generate');
    Route::get('/dashboard/requests', [UserDashboardController::class, 'requests'])->name('dashboard.requests');
    Route::get('/dashboard/requests/{scrapeRequest}/status', [UserDashboardController::class, 'requestStatus'])->name('dashboard.requests.status');
    Route::get('/dashboard/usage', [UserDashboardController::class, 'usage'])->name('dashboard.usage');
    Route::get('/dashboard/playground', [UserDashboardController::class, 'playground'])->name('dashboard.playground');
});

require __DIR__.'/auth.php';