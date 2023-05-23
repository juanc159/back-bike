<?php

use App\Http\Controllers\Api\PermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Permission
|--------------------------------------------------------------------------
*/
Route::post('/permission-list', [PermissionController::class, 'list'])->name('api.permission.list');
Route::post('/permission-create', [PermissionController::class, 'store'])->name('api.permission.store');
Route::put('/permission-update', [PermissionController::class, 'store'])->name('api.permission.update');
Route::delete('/permission-delete/{id}', [PermissionController::class, 'delete'])->name('api.permission.delete');
Route::get('/permission-info/{id}', [PermissionController::class, 'info'])->name('api.permission.info');
Route::get('/permission-dataForm', [PermissionController::class, 'dataForm'])->name('api.permission.dataForm');
