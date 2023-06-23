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
Route::get('/mecanic-info/{id}', [MecanicController::class, 'info'])->name('api.mecanic.info');
 