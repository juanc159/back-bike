<?php

use App\Http\Controllers\Api\IncomeVehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/incomeVehicle-list', [IncomeVehicleController::class, 'list'])->name('api.incomeVehicle.list');
Route::post('/incomeVehicle-dataForm', [IncomeVehicleController::class, 'dataForm'])->name('api.incomeVehicle.dataForm');
Route::post('/incomeVehicle-create', [IncomeVehicleController::class, 'store'])->name('api.incomeVehicle.store');
Route::put('/incomeVehicle-update', [IncomeVehicleController::class, 'store'])->name('api.incomeVehicle.update');
Route::delete('/incomeVehicle-delete/{id}', [IncomeVehicleController::class, 'delete'])->name('api.incomeVehicle.delete');
Route::get('/incomeVehicle-info/{id}', [IncomeVehicleController::class, 'info'])->name('api.incomeVehicle.info');
Route::post('/incomeVehicle-changeState', [IncomeVehicleController::class, 'changeState'])->name('api.incomeVehicle.changeState');
 