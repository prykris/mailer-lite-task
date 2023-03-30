<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SubscriberController;
use App\Http\Middleware\EnsureApiKeyIsSet;
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

Route::get('/', [ApiKeyController::class, 'index'])
    ->name('api-key');

Route::get('/subscribers', [SubscriberController::class, 'index'])
    ->middleware([EnsureApiKeyIsSet::class])
    ->name('subscribers');
