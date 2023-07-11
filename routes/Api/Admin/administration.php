<?php
 
use App\Http\Controllers\Api\AdministrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/administration-list', [AdministrationController::class, 'list'])->name('api.administration.list');
Route::post('/administration-create', [AdministrationController::class, 'store'])->name('api.administration.store');
Route::put('/administration-update', [AdministrationController::class, 'store'])->name('api.administration.update');
Route::delete('/administration-delete/{id}', [AdministrationController::class, 'delete'])->name('api.administration.delete');
Route::get('/administration-info/{id}', [AdministrationController::class, 'info'])->name('api.administration.info');
 