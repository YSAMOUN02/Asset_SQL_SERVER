<?php

use App\Http\Controllers\api\ApiHandlerController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:api')->group(function () {
    Route::get('/assets/{id}', [ApiHandlerController::class, 'raw_search_detail']);

    Route::get('/RawAssets/assets={assets}/fa={fa}/invoice={invoice}/description={description}/start={start}/end={end}/state={state}', [ApiHandlerController::class, 'Search_Raw_assets']);

    Route::post('/raw/assets', [ApiHandlerController::class, 'Search_Raw_assets']);

    Route::post('/fect/asset/data', [ApiHandlerController::class, 'search_list_asset_more']);

    Route::post('/fect/movement/data', [ApiHandlerController::class, 'search_list_movement_more']);

    Route::post('/fect/assets/new/data', [ApiHandlerController::class, 'search_list_asset_new_more']);


    Route::get('/fixAsset/location', [ApiHandlerController::class, 'fa_location']);


    Route::post('/quick/data/search', [ApiHandlerController::class, 'qucik_data_search']);


    Route::get('/assets_status', [ApiHandlerController::class, 'assets_status']);

    Route::post('/change/log', [ApiHandlerController::class, 'seach_changeLog']);

    Route::post('/search/mobile', [ApiHandlerController::class, 'mobile_search']);



    Route::post('/add/department', [ApiHandlerController::class, 'add_department']);


     Route::post('/delete/department', [ApiHandlerController::class, 'delete_department']);

     Route::post('/fect/assets/toggle', [ApiHandlerController::class, 'updateToggle']);

     Route::get('/fetch-users', [ApiHandlerController::class, 'fetchUsers']);


});
// route to fetch immediate children of a unit


Route::post('/login/submit', [ApiHandlerController::class, 'login_submit']);

Route::post('/check/name', [ApiHandlerController::class, 'check_name_for_reset_password']);
Route::post('/temp/login', [ApiHandlerController::class, 'temp_login_submit']);


