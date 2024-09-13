<?php

use App\Http\Controllers\api\ApiHandlerController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/assets/{id}', [ApiHandlerController::class, 'raw_search_detail']);

Route::get('/RawAssets/assets={assets}/fa={fa}/invoice={invoice}/description={description}/start={start}/end={end}/state={state}', [ApiHandlerController::class, 'Search_Raw_assets']);



Route::get('/fixAsset/location', [ApiHandlerController::class, 'fa_location']);



Route::get('/assets_status', [ApiHandlerController::class, 'assets_status']);




