<?php

use App\Http\Controllers\Api\PayrollController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payroll
|--------------------------------------------------------------------------
*/
Route::get('/payroll-dataForm/{company_id}', [PayrollController::class, 'dataForm'])->name('api.payroll.dataForm');
Route::get('/payroll-dataFormRefresh/{company_id}', [PayrollController::class, 'dataFormRefresh'])->name('api.payroll.dataFormRefresh');
Route::post('/payroll-list', [PayrollController::class, 'list'])->name('api.payroll.list');
Route::post('/payroll-create', [PayrollController::class, 'store'])->name('api.payroll.store');
Route::put('/payroll-update', [PayrollController::class, 'store'])->name('api.payroll.update');
Route::delete('/payroll-delete/{id}', [PayrollController::class, 'delete'])->name('api.payroll.delete');
Route::get('/payroll-info/{id}', [PayrollController::class, 'info'])->name('api.payroll.info');
Route::post('/payroll-importExcel', [PayrollController::class, 'importExcel'])->name('api.payroll.importExcel');
 