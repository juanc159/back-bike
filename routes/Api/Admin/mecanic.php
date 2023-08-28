<?php
 
use App\Http\Controllers\Api\MecanicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/mecanic-list', [MecanicController::class, 'list'])->name('api.mecanic.list');
Route::post('/mecanic-create', [MecanicController::class, 'store'])->name('api.mecanic.store');
Route::put('/mecanic-update', [MecanicController::class, 'store'])->name('api.mecanic.update');
Route::delete('/mecanic-delete/{id}', [MecanicController::class, 'delete'])->name('api.mecanic.delete');
Route::post('/mecanic-info', [MecanicController::class, 'info'])->name('api.mecanic.info');
Route::post('/mecanic-pay', [MecanicController::class, 'pay'])->name('api.mecanic.info');
 