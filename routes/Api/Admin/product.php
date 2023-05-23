<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Producto
|--------------------------------------------------------------------------
*/
Route::post('/product-list', [ProductController::class, 'list'])->name('api.product.list');
Route::post('/product-create', [ProductController::class, 'store'])->name('api.product.store');
Route::put('/product-update', [ProductController::class, 'store'])->name('api.product.update');
Route::delete('/product-delete/{id}', [ProductController::class, 'delete'])->name('api.product.delete');
Route::get('/product-info/{id}', [ProductController::class, 'info'])->name('api.product.info');
Route::post('/product-changeState', [ProductController::class, 'changeState'])->name('api.product.changeState');
Route::post('/product-dataForm', [ProductController::class, 'dataForm'])->name('api.product.dataForm');
Route::post('/product-excel', [ProductController::class, 'excel'])->name('api.product.excel');;
Route::post('/product-changeState', [ProductController::class, 'changeState'])->name('api.user.changeState'); 
Route::post('/product-select2', [ProductController::class, 'select2InfiniteList'])->name('api.product.select2');
Route::post('/product-importExcel', [ProductController::class, 'importExcel'])->name('api.payroll.importExcel');

