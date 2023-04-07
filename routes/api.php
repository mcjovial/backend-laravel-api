<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsApiController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/everything', [NewsApiController::class, 'everything']);
    Route::get('/sources', [NewsApiController::class, 'sources']);
    Route::get('/feed', [NewsApiController::class, 'feed']);
    Route::post('/feed', [NewsApiController::class, 'createFeed']);
    Route::post('/filter',[NewsApiController::class,'filter']);
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
