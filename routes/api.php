<?php

use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\PublicationController;
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

Route::post('/register', [PassportAuthController::class, 'register']);
Route::post('/login', [PassportAuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/get-user', [PassportAuthController::class, 'userInfo'])->name('sdasdas');
});

Route::post('/publication-listData', [PublicationController::class, 'listData'])->name('api.publication.list');
Route::get('/publication-viewDetail/{id}', [PublicationController::class, 'viewDetail'])->name('api.publication.list');

