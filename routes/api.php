<?php

use App\Http\Controllers\API\Analytics\EpisodeController as EpisodeAnalyticsController;
use App\Http\Controllers\API\EpisodeController;
use App\Http\Controllers\API\PodcastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1/')->group(function () {

    Route::prefix('podcasts')->group(function () {
        Route::get('/', [PodcastController::class, 'index']);
        Route::get('/{id}', [PodcastController::class, 'show']);
    });

    // I was split between nesting this inside podcasts since there's
    // a heirarchy there but I prefer this for absolutely no reason.

    Route::prefix('episodes')->group(function () {
        Route::get('/', [EpisodeController::class, 'index']);
        Route::get('/{id}', [EpisodeController::class, 'show']);
        Route::get('/{id}/download', [EpisodeController::class, 'download']);
    });


    Route::prefix('analytics')->group(function () {
        Route::prefix('episodes')->group(function () {
            Route::get(
                '/{episode}/downloads',
                [EpisodeAnalyticsController::class, 'downloads']
            );
        });
    });
});
