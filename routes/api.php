<?php

use App\Http\Controllers\Api\FarmingController;
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
    Route::get('countries',[FarmingController::class,'getCountries']);
    Route::post('get_states',[FarmingController::class,'getStates']);
    Route::post('get_districts',[FarmingController::class,'getDistricts']);   
    Route::post('get_blocks',[FarmingController::class,'getBlocks']);   
    Route::post('get_gram_panchyats',[FarmingController::class,'getGramPanchyats']);   
    Route::post('get_villages',[FarmingController::class,'getVillages']);   
    Route::resource('farming', FarmingController::class);
});
