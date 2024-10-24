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

    Route::post('/fect/asset/staff/data', [ApiHandlerController::class, 'search_list_asset_more_staff']);

    Route::post('/fect/movement/data', [ApiHandlerController::class, 'search_list_movement_more']);

    Route::post('/fect/search/movement/data', [ApiHandlerController::class, 'search_movement_more']);

    Route::get('/fixAsset/location', [ApiHandlerController::class, 'fa_location']);


    Route::post('/quick/data/search', [ApiHandlerController::class, 'qucik_data_search']);


    Route::get('/assets_status', [ApiHandlerController::class, 'assets_status']);

    Route::post('/change/log', [ApiHandlerController::class, 'seach_changeLog']);

    Route::post('/search/mobile', [ApiHandlerController::class, 'mobile_search']);

});

Route::post('/login/submit', [ApiHandlerController::class, 'login_submit']);



