<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

//Home Page route
Route::get('/', function () {
    return view('home');
});


// Company routes 
Route::resource('companies', CompanyController::class);

// Employee routes
Route::resource('employees', EmployeeController::class);

//Fetch Manager based on company selection for Employee Creation.
Route::get('/companies/{companyId}/managers', [EmployeeController::class, 'getManagers']);

