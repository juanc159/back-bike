<?php

use App\Http\Controllers\Api\SaleController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sales
|--------------------------------------------------------------------------
*/
Route::post('/sale-list', [SaleController::class, 'list'])->name('api.sale.list');
Route::post('/sale-create', [SaleController::class, 'store'])->name('api.sale.store');
Route::put('/sale-update', [SaleController::class, 'store'])->name('api.sale.update');
Route::delete('/sale-delete/{id}', [SaleController::class, 'delete'])->name('api.sale.delete');
Route::get('/sale-info/{id}', [SaleController::class, 'info'])->name('api.sale.info');
Route::post('/sale-dataForm', [SaleController::class, 'dataForm'])->name('api.sale.dataForm');
Route::post('/sale-excel', [SaleController::class, 'excel'])->name('api.sale.excel');
 