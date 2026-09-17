<?php

use App\Http\Controllers\Api\MonitorController;
use App\Http\Middleware\VerifyMonitorToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Unauthenticated on purpose: a deploy step or load balancer needs to check
// "does this container answer" before it has any secret to present.
Route::get('/health', [MonitorController::class, 'health'])->name('api.health');

// Detail lives behind VerifyMonitorToken. If MONITOR_API_TOKEN is unset the
// middleware itself refuses every request rather than falling open.
Route::middleware(VerifyMonitorToken::class)->prefix('monitor')->name('api.monitor.')->group(function () {
    Route::get('/services', [MonitorController::class, 'services'])->name('services');
    Route::get('/metrics', [MonitorController::class, 'metrics'])->name('metrics');
});
