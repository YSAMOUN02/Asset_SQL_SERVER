<?php

use App\Http\Controllers\backend\AssetsController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\ChangeLogController;
use App\Http\Controllers\backend\Data_setupController;
use App\Http\Controllers\backend\MovementController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AdminController::class, 'login'])->name('login');

Route::get('/forgot/password', [AdminController::class, 'forgot_password']);
Route::post('/login/submit', [AdminController::class, 'login_submit']);
Route::post('/login/code/submit', [AdminController::class, 'login_submit_code_to_reset']);
Route::post('/reset/password/submit', [AdminController::class, 'reset_submit']);

Route::middleware(['auth'])->group(function () {

    // Admin Feature ----------------------------------------------------------------------------------------------------
    Route::get('/', [AdminController::class, 'dashboard_admin']);

    Route::get('/admin/dasboard/{report}/{year}/{months}', [AdminController::class, 'dashboard_admin']);

    Route::get('/logout', [AdminController::class, 'logout']);

    Route::get('/units/{type}/{parent}', [UserController::class, 'getChildUnits']);
    Route::post('/hierarchy/{type}/{id}/delete', [UserController::class, 'deleteNode']);
    // Asset----------------------------------------------------------------------------------------------------
    // Raw Select
    Route::get('/admin/assets/add/{page}', [AssetsController::class, 'list_select']);
    // LIST
    Route::get('/admin/assets/{page}', [AssetsController::class, 'list_assets']);
    Route::get('/admin/assets/transaction/{page}', [AssetsController::class, 'list_transaction']);
    Route::get('/admin/assets/new/{page}', [AssetsController::class, 'assets_new']);
    // Add
    Route::get('/admin/assets/add/assets={assets}/invoice_no={invoice}', [AssetsController::class, 'assets_add']);
    Route::post('/admin/assets/add/submit', [AssetsController::class, 'assets_add_submit']);
    Route::post('/admin/assets/restore', [AssetsController::class, 'restore']);
    //Import
    Route::get('/admin/import/assets', [AssetsController::class, 'assets_import']);
    // Update and View
    Route::get('/admin/assets/data/{state}/id={id}/variant={variant}', [AssetsController::class, 'update_and_view_asset']);
    Route::post('/admin/assets/update/submit', [AssetsController::class, 'update_submit']);


    Route::get('/admin/assets/view/varaint={var}/id={id}', [AssetsController::class, 'view_varaint_asset']);
    // Delete
    Route::post('/admin/assets/admin/delete/submit', [AssetsController::class, 'delete_admin_asset']);
    // QR CODE Feature
    Route::get('/admin/qr/code/print/assets={assets}', [AssetsController::class, 'print_qr']);
    Route::post('/admin/qr/code/print/assets', [AssetsController::class, 'multi_print']);
    // Export
    Route::post('/admin/export/excel/assets', [AssetsController::class, 'multi_export']);
    Route::post('/admin/export/excel/movement', [AssetsController::class, 'multi_export_movement']);

    // Import
    Route::get('/admin/import/assets/template', [AssetsController::class, 'downloadAssetsTemplate']);
    Route::post('/admin/assets/import/submit', [AssetsController::class, 'import_submit']);





    // Movement
    Route::get('/admin/movement/add/detail/id={id}', [MovementController::class, 'movement']);
    Route::post('/admin/movement/add/submit', [MovementController::class, 'movement_add_submit']);




    // Change History----------------------------------------------------------------------------------------------------
    Route::get('/admin/change/log/{page}', [ChangeLogController::class, 'ChangeLog']);
    Route::post('/admin/change/log/search', [ChangeLogController::class, 'searchChangeLog']);


    // USER----------------------------------------------------------------------------------------------------
    // ADD
    Route::get('/admin/user/add', [UserController::class, 'add_user']);
    Route::POST('/admin/user/add/submit', [UserController::class, 'add_submit']);
    // LIST
    Route::get('/admin/user/list/{page}', [UserController::class, 'list_user']);
    // View
    Route::get('/admin/user/view/id={id}', [UserController::class, 'view_user']);
    // Update
    Route::get('/admin/user/update/id={id}', [UserController::class, 'update_user']);
    Route::post('/admin/user/update/submit', [UserController::class, 'update_user_submit']);
    // Delete
    Route::post('/admin/user/delete/submit', [UserController::class, 'delete_user']);
    Route::post('/admin/user/search', [UserController::class, 'search_user']);
    Route::post('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);

    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/search-users', [UserController::class, 'searchUsers']);

    // Data Set up----------------------------------------------------------------------------------------------------
    Route::get('/hierarchical', [Data_setupController::class, 'hierarchical']);
    Route::get('/hierarchy/{type}/{id}/children', [Data_setupController::class, 'children']);
    Route::get('/hierarchy/{type}/{id}/users', [Data_setupController::class, 'users']);
    Route::post('/hierarchy/{type}/{parentId}/add-child', [Data_setupController::class, 'addChild']);
    Route::post('/hierarchy/add-company', [Data_setupController::class, 'addCompany']);
    Route::get('/hierarchy/can-delete/{type}/{id}', [Data_setupController::class, 'canDeleteNodeApi']);
    Route::post('/hierarchy/move-user', [Data_setupController::class, 'moveUser']);
    Route::post('/hierarchy/{type}/{id}/update', [Data_setupController::class, 'updateNode']);
    Route::get('/search-datalist', [Data_setupController::class, 'searchDatalist'])->name('search.datalist');

    Route::get('/hierarchy/search', [Data_setupController::class, 'search_user_hierarchy']);

    Route::get('/code/setup', [Data_setupController::class, 'code_setup']);
    Route::post('/code/add/submit', [Data_setupController::class, 'code_new_submit']);
    Route::post('/code/update/submit', [Data_setupController::class, 'code_update_submit']);
    Route::post('/code/delete/submit', [Data_setupController::class, 'code_delete_submit']);

    Route::get('/code_mamnual/setup', [Data_setupController::class, 'code_mamnual_setup']);




    Route::get('/reference/setup', [Data_setupController::class, 'reference_setup']);
    Route::post('/reference/add/submit', [Data_setupController::class, 'reference_new_submit']);
    Route::post('/reference/update/submit', [Data_setupController::class, 'reference_update_submit']);
    Route::post('/reference/delete/submit', [Data_setupController::class, 'reference_delete_submit']);
});
