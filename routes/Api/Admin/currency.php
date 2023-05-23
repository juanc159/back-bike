<?php

use App\Http\Controllers\Api\CurrencyController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Monedas
|--------------------------------------------------------------------------
*/
 
Route::post('/currencies-select2', [CurrencyController::class, 'select2InfiniteList'])->name('api.product.select2');

