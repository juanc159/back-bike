<?php

use App\Http\Controllers\Api\ThirdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tercero
|--------------------------------------------------------------------------
*/
Route::post('/third-list', [ThirdController::class, 'list'])->name('api.third.list');
Route::post('/third-create', [ThirdController::class, 'store'])->name('api.third.store');
Route::put('/third-update', [ThirdController::class, 'store'])->name('api.third.update');
Route::delete('/third-delete/{id}', [ThirdController::class, 'delete'])->name('api.third.delete');
Route::get('/third-info/{id}', [ThirdController::class, 'info'])->name('api.third.info');
Route::post('/third-dataForm', [ThirdController::class, 'dataForm'])->name('api.third.dataForm');
Route::post('/third-state', [ThirdController::class, 'changeState'])->name('api.third.state');

Route::post('/third-excel', [ThirdController::class, 'excel'])->name('api.third.excel');
Route::post('/third-select2', [ThirdController::class, 'select2InfiniteList'])->name('api.third.select2');