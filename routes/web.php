<?php

use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\ApiRequestController;
use App\Http\Controllers\SubscriberController;
use App\Http\Middleware\EnsureApiKeyIsSet;
use App\Http\Middleware\RestoreApiKey;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware([RestoreApiKey::class])->group(function () {
    Route::get('/api-key/requests', [ApiRequestController::class, 'index'])->name('api-requests-count');

    Route::controller(ApiKeyController::class)->group(function () {
        Route::get('/api-key', 'index')->name('api-key');
        Route::post('/api-key/store', 'store')->name('api-key-store');
    });


    Route::middleware([EnsureApiKeyIsSet::class])->group(function () {
        Route::controller(SubscriberController::class)->group(function () {
            Route::get('/subscribers', 'index')->name('subscribers');
        });

        Route::controller(SubscriberController::class)->group(function () {
            Route::get('/subscribers/data', 'index')->name('subscribers.data');
            Route::delete('/subscribers/delete', 'delete')->name('subscribers.delete');
            Route::post('/subscribers/create', 'create')->name('subscribers.create');
            Route::put('/subscribers/update', 'update')->name('subscribers.update');
        });
    });

});

Route::fallback(fn() => redirect(route('api-key')));
