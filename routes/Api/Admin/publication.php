<?php

use App\Http\Controllers\Api\PublicationController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/
Route::post('/publication-list', [PublicationController::class, 'list'])->name('api.publication.list');
Route::post('/publication-create', [PublicationController::class, 'store'])->name('api.publication.store');
Route::put('/publication-update', [PublicationController::class, 'store'])->name('api.publication.update');
Route::delete('/publication-delete/{id}', [PublicationController::class, 'delete'])->name('api.publication.delete');
Route::get('/publication-info/{id}', [PublicationController::class, 'info'])->name('api.publication.info');
Route::post('/publication-changeState', [PublicationController::class, 'changeState'])->name('api.publication.changeState');
 