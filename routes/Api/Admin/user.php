<?php

use App\Http\Controllers\Api\Usercontroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
Route::post('/user-list', [Usercontroller::class, 'list'])->name('api.role.list');
Route::post('/user-create', [Usercontroller::class, 'store'])->name('api.role.store');
Route::put('/user-update', [Usercontroller::class, 'store'])->name('api.role.update');
Route::delete('/user-delete/{id}', [Usercontroller::class, 'delete'])->name('api.role.delete');
Route::get('/user-info/{id}', [Usercontroller::class, 'info'])->name('api.role.info');
Route::post('/user-dataForm', [Usercontroller::class, 'dataForm'])->name('api.permission.dataForm');
Route::post('/user-changeState', [Usercontroller::class, 'changeState'])->name('api.user.changeState');
Route::post('/user-select2', [Usercontroller::class, 'select2InfiniteList'])->name('api.user.select2');
