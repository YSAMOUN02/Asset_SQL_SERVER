<?php

use App\Http\Controllers\backend\AssetsController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\ChangeLogController;
use App\Http\Controllers\backend\QuickDataController;
use App\Http\Controllers\backend\MovementController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AdminController::class, 'login'])->name('login');

Route::get('/forgot/password', [AdminController::class, 'forgot_password']);
Route::post('/login/submit', [AdminController::class, 'login_submit']);
Route::middleware(['auth'])->group(function () {

    // Admin Feature ----------------------------------------------------------------------------------------------------
    Route::get('/', [AdminController::class, 'dashboard_admin']);
    Route::get('/logout', [AdminController::class, 'logout']);


    // Asset----------------------------------------------------------------------------------------------------
    // Raw Select
    Route::get('/admin/assets/add/{page}', [AssetsController::class, 'list_select']);
    // LIST
    Route::get('/admin/assets/{page}', [AssetsController::class, 'list_assets']);
    Route::get('/admin/assets/transaction/{page}', [AssetsController::class, 'list_transaction']);
    // Add
    Route::get('/admin/assets/add/assets={assets}/invoice_no={invoice}', [AssetsController::class, 'assets_add']);
    Route::post('/admin/assets/add/submit', [AssetsController::class, 'assets_add_submit']);
    Route::post('/admin/assets/restore', [AssetsController::class, 'restore']);
    //Import
    Route::get('/admin/import/assets', [AssetsController::class, 'assets_import']);
    // Update
    Route::get('/admin/assets/edit/id={id}', [AssetsController::class, 'update_asset']);
    Route::post('/admin/assets/update/submit', [AssetsController::class, 'update_submit']);
    // View
    Route::get('/admin/assets/view/id={id}', [AssetsController::class, 'view_asset']);
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


    // QUICK DATA----------------------------------------------------------------------------------------------------
    // LIST
    Route::get('/quick/data/{page}', [QuickDataController::class, 'control_quick_data']);
    // ADD
    Route::post('/quick/data/add', [QuickDataController::class, 'add_submit_quick_data']);
    // Delete
    Route::post('/admin/quick/data/delete/submit', [QuickDataController::class, 'delete_quick_data']);
    // Update
    Route::post('/admin/quick/data/update/submit', [QuickDataController::class, 'update_quick_data']);



    // USER----------------------------------------------------------------------------------------------------
    // ADD
    Route::get('/admin/user/add', [UserController::class, 'add_user']);
    Route::POST('/admin/user/add/submit', [UserController::class, 'add_submit']);
    // LIST
    Route::get('/admin/user/list', [UserController::class, 'list_user']);
    // View
    Route::get('/admin/user/view/id={id}', [UserController::class, 'view_user']);
    // Update
    Route::get('/admin/user/update/id={id}', [UserController::class, 'update_user']);
    Route::post('/admin/user/update/submit', [UserController::class, 'update_user_submit']);
    // Delete
    Route::post('/admin/user/delete/submit', [UserController::class, 'delete_user']);


    // Change History----------------------------------------------------------------------------------------------------
    Route::get('/admin/assets/change/log/{page}', [ChangeLogController::class, 'ChangeLog']);




    // Temp
    // Route::post('/admin/assets/list/search', [AssetsController::class, 'list_asset_search']);
    // Route::post('/admin/assets/add/search', [AssetsController::class, 'assets_add_by_search']);
    // Route::post('/admin/assets/staff/delete/submit', [AssetsController::class, 'staff_delete_submit']);
    // Route::get('/admin/movement/add/{page}', [MovementController::class, 'add_transfer']);
    // Route::get('/admin/movement/add/detail/id={id}', [MovementController::class, 'add_transfer_detail']);
    // Route::post('/admin/movement/add/detail/submit', [MovementController::class, 'add_transfer_submit']);
    // Route::get('/admin/movement/list/{page}', [MovementController::class, 'movement_list']);
    // Route::get('/admin/movement/edit/id={id}/assets_id={assets_id}/varaint={assets_varaint}', [MovementController::class, 'update_movement_detail']);
    // Route::get('/admin/movement/view/id={id}/assets_id={assets_id}/varaint={assets_varaint}', [MovementController::class, 'view_movement_detail']);
    // Route::post('/admin/movement/admin/delete/submit', [MovementController::class, 'delete_movement_detail']);
    // Route::get('/admin/movement/timeline/id={id}', [MovementController::class, 'movement_timeline']);
    // Route::post('/admin/movement/admin/update/submit', [MovementController::class, 'update_movement_submit']);


});
