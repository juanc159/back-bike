<?php
 
use App\Http\Controllers\Api\ThirdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/third-list', [ThirdController::class, 'list'])->name('api.third.list');
Route::post('/third-create', [ThirdController::class, 'store'])->name('api.third.store');
Route::put('/third-update', [ThirdController::class, 'store'])->name('api.third.update');
Route::delete('/third-delete/{id}', [ThirdController::class, 'delete'])->name('api.third.delete');
Route::get('/third-info/{id}', [ThirdController::class, 'info'])->name('api.third.info');
 