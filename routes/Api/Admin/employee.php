<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmployeeWorkingInformationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| employee Basic data
|--------------------------------------------------------------------------
*/
Route::post('/employee-list', [EmployeeController::class, 'list'])->name('api.employee.list');
Route::post('/employee-create', [EmployeeController::class, 'store'])->name('api.employee.store');
Route::put('/employee-update', [EmployeeController::class, 'store'])->name('api.employee.update');
Route::delete('/employee-delete/{id}', [EmployeeController::class, 'delete'])->name('api.employee.delete');
Route::get('/employee-info/{id}', [EmployeeController::class, 'info'])->name('api.employee.info');
Route::get('/employee-basicData-dataForm', [EmployeeController::class, 'basicDataDataForm'])->name('api.employee.basicData.dataForm');

/*
|--------------------------------------------------------------------------
| employee working Information
|--------------------------------------------------------------------------
*/
Route::post('/employee-workingInformation-dataForm', [EmployeeController::class, 'workingInformationDataForm'])->name('api.employee.workingInformation.dataForm');
Route::post('/employee-workingInformation-list', [EmployeeWorkingInformationController::class, 'list'])->name('api.employee.workingInformation.list');
Route::post('/employee-workingInformation-create', [EmployeeWorkingInformationController::class, 'store'])->name('api.employee.workingInformation.store');
Route::put('/employee-workingInformation-update', [EmployeeWorkingInformationController::class, 'store'])->name('api.employee.workingInformation.update');
Route::delete('/employee-workingInformation-delete/{id}', [EmployeeWorkingInformationController::class, 'delete'])->name('api.employee.workingInformation.delete');
Route::get('/employee-workingInformation-info/{employee_id}', [EmployeeWorkingInformationController::class, 'info'])->name('api.employee.workingInformation.info');
