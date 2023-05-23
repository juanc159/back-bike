<?php

use App\Http\Controllers\Api\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Companies
|--------------------------------------------------------------------------
*/
Route::post('/company-list', [CompanyController::class, 'list'])->name('api.company.list');
Route::post('/company-create', [CompanyController::class, 'store'])->name('api.company.store');
Route::put('/company-update', [CompanyController::class, 'store'])->name('api.company.update');
Route::delete('/company-delete/{id}', [CompanyController::class, 'delete'])->name('api.company.delete');
Route::get('/company-info/{id}', [CompanyController::class, 'info'])->name('api.company.info');
Route::post('/company-changeState', [CompanyController::class, 'changeState'])->name('api.company.changeState');
