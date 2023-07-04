<?php

use App\Http\Controllers\Feed\FeedCreateMessagePostController;
use App\Http\Controllers\Feed\FeedGetMessageController;
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

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'feed'], function() {
        Route::get('/', FeedGetMessageController::class)->name('feed-get-message');
        Route::post('/create-message', FeedCreateMessagePostController::class)->name('feed-create-message');
    });
});

