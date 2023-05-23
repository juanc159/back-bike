<?php

use App\Http\Controllers\Api\TypesReceiptInvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invoice
|--------------------------------------------------------------------------
*/
Route::post('/invoice-list', [TypesReceiptInvoiceController::class, 'list'])->name('api.invoice.list');
Route::post('/invoice-create', [TypesReceiptInvoiceController::class, 'store'])->name('api.invoice.store');
Route::put('/invoice-update', [TypesReceiptInvoiceController::class, 'store'])->name('api.invoice.update');
Route::delete('/invoice-delete/{id}', [TypesReceiptInvoiceController::class, 'delete'])->name('api.invoice.delete');
Route::get('/invoice-info/{id}', [TypesReceiptInvoiceController::class, 'info'])->name('api.invoice.info');
Route::post('/invoice-dataForm', [TypesReceiptInvoiceController::class, 'dataForm'])->name('api.invoice.dataForm');
 Route::post('/invoice-cities', [TypesReceiptInvoiceController::class, 'getCities'])->name('api.invoice.cities');
Route::post('/invoice-listAuxiliaryAndSubAuxiliary', [TypesReceiptInvoiceController::class, 'listAuxiliaryAndSubAuxiliary'])->name('api.invoice.listAuxiliaryAndSubAuxiliary');
Route::post('/invoice-excel', [TypesReceiptInvoiceController::class, 'excel']);
Route::post('/invoice-select2', [TypesReceiptInvoiceController::class, 'select2InfiniteList'])->name('api.invoice.select2');