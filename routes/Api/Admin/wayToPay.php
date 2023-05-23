<?php

use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\WayToPayGeneralController;
use App\Http\Controllers\Api\WayToPayPayOnLineController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| General
|--------------------------------------------------------------------------
*/
Route::post('/general-list', [WayToPayGeneralController::class, 'list'])->name('api.general.list'); 
Route::post('/general-create', [WayToPayGeneralController::class, 'store'])->name('api.general.store');
Route::put('/general-update', [WayToPayGeneralController::class, 'store'])->name('api.general.update');
Route::delete('/general-delete/{id}', [WayToPayGeneralController::class, 'delete'])->name('api.general.delete');
Route::get('/general-info/{id}', [WayToPayGeneralController::class, 'info'])->name('api.general.info');
Route::post('/general-changeState', [WayToPayGeneralController::class, 'changeState'])->name('api.general.changeState');
/*
|--------------------------------------------------------------------------
| Pago en linea
|--------------------------------------------------------------------------
*/
Route::post('/payOnLine-list', [WayToPayPayOnLineController::class, 'list'])->name('api.payOnLine.list');
Route::post('/payOnLine-create', [WayToPayPayOnLineController::class, 'store'])->name('api.payOnLine.store');
Route::put('/payOnLine-update', [WayToPayPayOnLineController::class, 'store'])->name('api.payOnLine.update');
Route::delete('/payOnLine-delete/{id}', [WayToPayPayOnLineController::class, 'delete'])->name('api.payOnLine.delete');
Route::get('/payOnLine-info/{id}', [WayToPayPayOnLineController::class, 'info'])->name('api.payOnLine.info');
Route::post('/payOnLine-changeState', [WayToPayPayOnLineController::class, 'changeState'])->name('api.payOnLine.changeState');



/*
|--------------------------------------------------------------------------
| Metodos de pago
|--------------------------------------------------------------------------
*/
Route::post('/paymentMethods-list', [PaymentMethodController::class, 'list'])->name('api.paymentMethods.list'); 