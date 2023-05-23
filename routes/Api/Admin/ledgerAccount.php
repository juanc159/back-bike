<?php

use App\Http\Controllers\Api\LedgerAccountAccountController;
use App\Http\Controllers\Api\LedgerAccountAuxiliaryController;
use App\Http\Controllers\Api\LedgerAccountClassController;
use App\Http\Controllers\Api\LedgerAccountGroupController;
use App\Http\Controllers\Api\LedgerAccountSubAccountController;
use App\Http\Controllers\Api\LedgerAccountSubAuxiliaryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sub Auxiliares => subAuxiliary 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-excel', [LedgerAccountClassController::class, 'excel']);
/*
|--------------------------------------------------------------------------
| Cuentas contables => clases
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-list', [LedgerAccountClassController::class, 'list'])->name('api.ledgerAccount.list');

/*
|--------------------------------------------------------------------------
| Cuentas contables => Grupos 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-group-list', [LedgerAccountGroupController::class, 'list'])->name('api.ledgerAccount.group.list');
Route::post('/ledgerAccount-group-create', [LedgerAccountGroupController::class, 'store'])->name('api.ledgerAccount.group.store');
Route::put('/ledgerAccount-group-update', [LedgerAccountGroupController::class, 'store'])->name('api.ledgerAccount.group.update');
Route::delete('/ledgerAccount-group-delete/{id}', [LedgerAccountGroupController::class, 'delete'])->name('api.ledgerAccount.group.delete');
Route::get('/ledgerAccount-group-info/{id}', [LedgerAccountGroupController::class, 'info'])->name('api.ledgerAccount.group.info');
 
/*
|--------------------------------------------------------------------------
| Cuentas contables => Accounts 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-account-list', [LedgerAccountAccountController::class, 'list'])->name('api.ledgerAccount.account.list');
Route::post('/ledgerAccount-account-create', [LedgerAccountAccountController::class, 'store'])->name('api.ledgerAccount.account.store');
Route::put('/ledgerAccount-account-update', [LedgerAccountAccountController::class, 'store'])->name('api.ledgerAccount.account.update');
Route::delete('/ledgerAccount-account-delete/{id}', [LedgerAccountAccountController::class, 'delete'])->name('api.ledgerAccount.account.delete');
Route::get('/ledgerAccount-account-info/{id}', [LedgerAccountAccountController::class, 'info'])->name('api.ledgerAccount.account.info');
 

/*
|--------------------------------------------------------------------------
| Cuentas contables => SubAccounts 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-subAccount-list', [LedgerAccountSubAccountController::class, 'list'])->name('api.ledgerAccount.subAccount.list');
Route::post('/ledgerAccount-subAccount-create', [LedgerAccountSubAccountController::class, 'store'])->name('api.ledgerAccount.subAccount.store');
Route::put('/ledgerAccount-subAccount-update', [LedgerAccountSubAccountController::class, 'store'])->name('api.ledgerAccount.subAccount.update');
Route::delete('/ledgerAccount-subAccount-delete/{id}', [LedgerAccountSubAccountController::class, 'delete'])->name('api.ledgerAccount.subAccount.delete');
Route::get('/ledgerAccount-subAccount-info/{id}', [LedgerAccountSubAccountController::class, 'info'])->name('api.ledgerAccount.subAccount.info');

/*
|--------------------------------------------------------------------------
| Auxiliares => Auxiliary 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-auxiliary-list', [LedgerAccountAuxiliaryController::class, 'list'])->name('api.ledgerAccount.auxiliary.list');
Route::post('/ledgerAccount-auxiliary-create', [LedgerAccountAuxiliaryController::class, 'store'])->name('api.ledgerAccount.auxiliary.store');
Route::put('/ledgerAccount-auxiliary-update', [LedgerAccountAuxiliaryController::class, 'store'])->name('api.ledgerAccount.auxiliary.update');
Route::delete('/ledgerAccount-auxiliary-delete/{id}', [LedgerAccountAuxiliaryController::class, 'delete'])->name('api.ledgerAccount.auxiliary.delete');
Route::get('/ledgerAccount-auxiliary-info/{id}', [LedgerAccountAuxiliaryController::class, 'info'])->name('api.ledgerAccount.auxiliary.info');
/*
|--------------------------------------------------------------------------
| Sub Auxiliares => subAuxiliary 
|--------------------------------------------------------------------------
*/
Route::post('/ledgerAccount-subAuxiliary-list', [LedgerAccountSubAuxiliaryController::class, 'list'])->name('api.ledgerAccount.subAuxiliary.list');
Route::post('/ledgerAccount-subAuxiliary-create', [LedgerAccountSubAuxiliaryController::class, 'store'])->name('api.ledgerAccount.subAuxiliary.store');
Route::put('/ledgerAccount-subAuxiliary-update', [LedgerAccountSubAuxiliaryController::class, 'store'])->name('api.ledgerAccount.subAuxiliary.update');
Route::delete('/ledgerAccount-subAuxiliary-delete/{id}', [LedgerAccountSubAuxiliaryController::class, 'delete'])->name('api.ledgerAccount.subAuxiliary.delete');
Route::get('/ledgerAccount-subAuxiliary-info/{id}', [LedgerAccountSubAuxiliaryController::class, 'info'])->name('api.ledgerAccount.subAuxiliary.info');
