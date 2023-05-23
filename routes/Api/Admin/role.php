<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Role
|--------------------------------------------------------------------------
*/
Route::post('/role-list', [RoleController::class, 'list'])->name('api.role.list');
Route::post('/role-create', [RoleController::class, 'store'])->name('api.role.store');
Route::put('/role-update', [RoleController::class, 'store'])->name('api.role.update');
Route::delete('/role-delete/{id}', [RoleController::class, 'delete'])->name('api.role.delete');
Route::get('/role-info/{id}', [RoleController::class, 'info'])->name('api.role.info');
Route::get('/role-dataForm', [RoleController::class, 'dataForm'])->name('api.role.dataForm');