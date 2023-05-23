<?php

use App\Http\Controllers\Api\CashReceiptController;
use App\Http\Controllers\Api\CashReceiptConfigurationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cash Receipt
|--------------------------------------------------------------------------
*/
Route::post('/cashReceipt-list', [CashReceiptController::class, 'list'])->name('api.cashReceipt.list');
Route::post('/cashReceipt-create', [CashReceiptController::class, 'store'])->name('api.cashReceipt.store');
Route::put('/cashReceipt-update', [CashReceiptController::class, 'store'])->name('api.cashReceipt.update');
Route::delete('/cashReceipt-delete/{id}', [CashReceiptController::class, 'delete'])->name('api.cashReceipt.delete');
Route::get('/cashReceipt-info/{id}', [CashReceiptController::class, 'info'])->name('api.cashReceipt.info');
Route::post('/cashReceipt-dataForm', [CashReceiptController::class, 'dataForm'])->name('api.cashReceipt.dataForm');

/*
|--------------------------------------------------------------------------
| Cash Receipt Configuration
|--------------------------------------------------------------------------
*/
Route::post('/cashReceiptConfiguration-list', [CashReceiptConfigurationController::class, 'list'])->name('api.cashReceiptConfiguration.list');
Route::post('/cashReceiptConfiguration-create', [CashReceiptConfigurationController::class, 'store'])->name('api.cashReceiptConfiguration.store');
Route::put('/cashReceiptConfiguration-update', [CashReceiptConfigurationController::class, 'store'])->name('api.cashReceiptConfiguration.update');
Route::delete('/cashReceiptConfiguration-delete/{id}', [CashReceiptConfigurationController::class, 'delete'])->name('api.cashReceiptConfiguration.delete');
Route::get('/cashReceiptConfiguration-info/{id}', [CashReceiptConfigurationController::class, 'info'])->name('api.cashReceiptConfiguration.info');
Route::post('/cashReceiptConfiguration-dataForm', [CashReceiptConfigurationController::class, 'dataForm'])->name('api.cashReceiptConfiguration.dataForm');

