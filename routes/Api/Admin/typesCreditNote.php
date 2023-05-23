<?php

use App\Http\Controllers\Api\TypesCreditNoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invoice
|--------------------------------------------------------------------------
*/
Route::post('/typesCreditNote-list', [TypesCreditNoteController::class, 'list'])->name('api.invoice.list');
Route::post('/typesCreditNote-create', [TypesCreditNoteController::class, 'store'])->name('api.invoice.store');
Route::put('/typesCreditNote-update', [TypesCreditNoteController::class, 'store'])->name('api.invoice.update');
Route::delete('/typesCreditNote-delete/{id}', [TypesCreditNoteController::class, 'delete'])->name('api.invoice.delete');
Route::get('/typesCreditNote-info/{id}', [TypesCreditNoteController::class, 'info'])->name('api.invoice.info');
Route::post('/typesCreditNote-dataForm', [TypesCreditNoteController::class, 'dataForm'])->name('api.invoice.dataForm');
Route::post('/typesCreditNote-state', [TypesCreditNoteController::class, 'changeState'])->name('api.invoice.state');
Route::post('/typesCreditNote-cities', [TypesCreditNoteController::class, 'getCities'])->name('api.invoice.cities');
Route::post('/typesCreditNote-listAuxiliaryAndSubAuxiliary', [TypesCreditNoteController::class, 'listAuxiliaryAndSubAuxiliary'])->name('api.invoice.listAuxiliaryAndSubAuxiliary');
Route::post('/typesCreditNote-excel', [TypesCreditNoteController::class, 'excel']);
Route::post('/typesCreditNote-select2', [TypesCreditNoteController::class, 'select2InfiniteList'])->name('api.invoice.select2');