<?php

use App\Http\Controllers\Api\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Menu
|--------------------------------------------------------------------------
*/
Route::post('/menu-list', [MenuController::class, 'list'])->name('api.menu.list');
Route::post('/menu-create', [MenuController::class, 'store'])->name('api.menu.store');
Route::put('/menu-update', [MenuController::class, 'store'])->name('api.menu.update');
Route::delete('/menu-delete/{id}', [MenuController::class, 'delete'])->name('api.menu.delete');
Route::get('/menu-info/{id}', [MenuController::class, 'info'])->name('api.menu.info');
