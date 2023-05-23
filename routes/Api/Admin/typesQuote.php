<?php

use App\Http\Controllers\Api\TypesQuoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| types Quote
|--------------------------------------------------------------------------
*/
Route::post('/typesQuote-list', [TypesQuoteController::class, 'list'])->name('api.typesQuote.list');
Route::post('/typesQuote-create', [TypesQuoteController::class, 'store'])->name('api.typesQuote.store');
Route::put('/typesQuote-update', [TypesQuoteController::class, 'store'])->name('api.typesQuote.update');
Route::delete('/typesQuote-delete/{id}', [TypesQuoteController::class, 'delete'])->name('api.typesQuote.delete');
Route::get('/typesQuote-info/{id}', [TypesQuoteController::class, 'info'])->name('api.typesQuote.info');
Route::post('/typesQuote-dataForm', [TypesQuoteController::class, 'dataForm'])->name('api.typesQuote.dataForm');
 Route::post('/typesQuote-excel', [TypesQuoteController::class, 'excel']);
Route::post('/typesQuote-select2', [TypesQuoteController::class, 'select2InfiniteList'])->name('api.typesQuote.select2');