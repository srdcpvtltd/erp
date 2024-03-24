<?php

use App\Http\Controllers\Api\AllowanceController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FarmingController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SalaryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'ApiController@login');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('get-projects', [ApiController::class, 'getProjects']);
    Route::post('add-tracker', [ApiController::class, 'addTracker']);
    Route::post('stop-tracker', [ApiController::class, 'stopTracker']);
    Route::post('upload-photos', [ApiController::class, 'uploadImage']);
    Route::get('get-user-permissions',[PermissionController::class,'getUserPermissions']);
    // Location Apis
    Route::get('countries',[FarmingController::class,'getCountries']);
    Route::post('get_states',[FarmingController::class,'getStates']);
    Route::post('get_districts',[FarmingController::class,'getDistricts']);   
    Route::post('get_blocks',[FarmingController::class,'getBlocks']);   
    Route::post('get_gram_panchyats',[FarmingController::class,'getGramPanchyats']);   
    Route::post('get_villages',[FarmingController::class,'getVillages']);   
    Route::get('get_seed_categories',[FarmingController::class,'getSeedCategories']);   
    Route::get('get_zones',[FarmingController::class,'getZones']);   
    Route::post('get_centers',[FarmingController::class,'getCenter']);   
    // Farming Regisration Api
    Route::resource('farming', FarmingController::class)->only(['index']);
    Route::post('farming/create', [FarmingController::class,'store']);
    // Employee Setup Apis
    Route::get('employees', [EmployeeController::class,'index']);
    Route::get('employees/get_documents', [EmployeeController::class,'getDocuments']);
    Route::get('employees/get_branches', [EmployeeController::class,'getBranches']);
    Route::get('employees/get_departments', [EmployeeController::class,'getDepartments']);
    Route::get('employees/get_designations', [EmployeeController::class,'getDesignations']);
    Route::get('employees/get_employees', [EmployeeController::class,'getEmployees']);
    Route::get('employees/get_employee_id', [EmployeeController::class,'getEmployeeID']);
    Route::get('employees/detail/{id}', [EmployeeController::class,'getEmployee']);
    Route::get('employees/destroy/{id}', [EmployeeController::class,'destroy']);
    Route::post('employees/update', [EmployeeController::class,'update']);
    Route::post('employees/store', [EmployeeController::class,'store']);
    // Employee Salry Setup
    Route::get('employees/get_payslip_types', [SalaryController::class,'getPayslipTypes']);
    Route::post('employees/update_basic_salary', [SalaryController::class,'updateBasicSalary']);
    // Employee Allowance Setup
    Route::get('employees/get_allowance_option', [AllowanceController::class,'getAllowanceOptions']);
    Route::get('employees/get_allowance_types', [AllowanceController::class,'getAllowanceTypes']);
    Route::get('employees/get_allowances', [AllowanceController::class,'getAllowances']);
    Route::post('employees/store_allowance', [AllowanceController::class,'store']);

});
