<?php

use App\Http\Controllers\Api\InventoryController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/inventory-list', [InventoryController::class, 'list'])->name('api.inventory.list');
Route::post('/inventory-create', [InventoryController::class, 'store'])->name('api.inventory.store');
Route::put('/inventory-update', [InventoryController::class, 'store'])->name('api.inventory.update');
Route::delete('/inventory-delete/{id}', [InventoryController::class, 'delete'])->name('api.inventory.delete');
Route::get('/inventory-info/{id}', [InventoryController::class, 'info'])->name('api.inventory.info');
 