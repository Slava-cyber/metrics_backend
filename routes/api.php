<?php

use App\Http\Controllers\ClickController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('click')->group(function () {
    Route::controller(ClickController::class)->group(function () {
        Route::post('/', 'store');
    });
});

Route::prefix('domain')->group(function () {
    Route::controller(DomainController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/', 'update');
        Route::get('/{domain}', 'show');
    });
});

Route::prefix('page')->group(function () {
    Route::controller(PageController::class)->group(function () {
        Route::get('/{page}', 'show');
    });
});

Route::prefix('metrics')->group(function () {
    Route::controller(MetricsController::class)->group(function () {
        Route::get('/domain/{domainId}/histogram', 'getHistogramAttendanceData');
        Route::get('/page/{pageId}/heatMap', 'getHeatMapData');
    });
});

