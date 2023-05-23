<?php

use App\Http\Controllers\Api\ChargeCatalogController;
use App\Http\Controllers\Api\GeneralParametrizationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Charge Catalog
|--------------------------------------------------------------------------
*/
Route::post('/chargeCatalog-list', [ChargeCatalogController::class, 'list'])->name('api.chargeCatalog.list');
Route::post('/chargeCatalog-create', [ChargeCatalogController::class, 'store'])->name('api.chargeCatalog.store');
Route::put('/chargeCatalog-update', [ChargeCatalogController::class, 'store'])->name('api.chargeCatalog.update');
Route::delete('/chargeCatalog-delete/{id}', [ChargeCatalogController::class, 'delete'])->name('api.chargeCatalog.delete');
Route::get('/chargeCatalog-info/{id}', [ChargeCatalogController::class, 'info'])->name('api.chargeCatalog.info');
Route::get('/chargeCatalog-dataForm', [ChargeCatalogController::class, 'dataForm'])->name('api.chargeCatalog.dataForm');
/*
|--------------------------------------------------------------------------
| Parametrizacion General
|--------------------------------------------------------------------------
*/
Route::post('/chargeCatalog-generalParametrization-list', [GeneralParametrizationController::class, 'list'])->name('api.chargeCatalog.generalParametrization.list');
Route::post('/chargeCatalog-generalParametrization-create', [GeneralParametrizationController::class, 'store'])->name('api.chargeCatalog.generalParametrization.store');
Route::put('/chargeCatalog-generalParametrization-update', [GeneralParametrizationController::class, 'store'])->name('api.chargeCatalog.generalParametrization.update');
Route::delete('/chargeCatalog-generalParametrization-delete/{id}', [GeneralParametrizationController::class, 'delete'])->name('api.chargeCatalog.generalParametrization.delete');
Route::get('/chargeCatalog-generalParametrization-info/{id}', [GeneralParametrizationController::class, 'info'])->name('api.chargeCatalog.generalParametrization.info');
