<?php

use App\Http\Controllers\Api\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('throttle:60,1')->group(function () {
    Route::post('/urls', [UrlController::class, 'store']);
    Route::get('/urls', [UrlController::class, 'index']);
});
