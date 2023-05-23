<?php

use App\Http\Controllers\Api\QuoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Form Cotizaciones
|--------------------------------------------------------------------------
*/
Route::post('/quotes-list', [QuoteController::class, 'list'])->name('api.quotes.list');
Route::post('/quotes-create', [QuoteController::class, 'store'])->name('api.quotes.store');
Route::put('/quotes-update', [QuoteController::class, 'store'])->name('api.quotes.update');
Route::delete('/quotes-delete/{id}', [QuoteController::class, 'delete'])->name('api.quotes.delete');
Route::get('/quotes-info/{id}', [QuoteController::class, 'info'])->name('api.quotes.info');
Route::post('/quotes-changeState', [QuoteController::class, 'changeState'])->name('api.quotes.changeState');
Route::post('/quotes-toInvoice', [QuoteController::class, 'toInvoice'])->name('api.quotes.toInvoice');
Route::post('/quotes-dataForm', [QuoteController::class, 'dataForm'])->name('api.quotes.dataForm');
Route::post('/quotes-excel', [QuoteController::class, 'excel'])->name('api.quotes.excel');
Route::get('/quotes-automaticNumbering/{id}', [QuoteController::class, 'automaticNumbering'])->name('api.quotes.automaticNumbering');