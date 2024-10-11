<?php

use App\Http\Controllers\backend\AssetsController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\ChangeLogController;
use App\Http\Controllers\backend\QuickDataController;
use App\Http\Controllers\backend\TransferController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login/submit', [AdminController::class, 'login_submit']);
Route::middleware(['auth'])->group(function () {


    Route::get('/', [AdminController::class, 'dashboard_admin']);
    Route::get('/logout', [AdminController::class, 'logout']);


    Route::get('/admin/assets/add/{page}', [AssetsController::class, 'list_select']);

    Route::get('/admin/assets/list/{page}', [AssetsController::class, 'list_assets']); // for added assets

    Route::post('/admin/assets/list/search', [AssetsController::class, 'list_asset_search']); // for added assets

    Route::get('/admin/assets/add/assets={assets}/invoice_no={invoice}', [AssetsController::class, 'assets_add']);

    Route::post('/admin/assets/add/submit', [AssetsController::class, 'assets_add_submit']);

    Route::post('/admin/assets/add/search', [AssetsController::class, 'assets_add_by_search']);

    
    Route::get('/admin/assets/edit/id={id}', [AssetsController::class, 'update_asset']);

   

    Route::post('/admin/assets/admin/delete/submit', [AssetsController::class, 'delete_admin_asset']);

    Route::get('/admin/assets/view/varaint={var}/id={id}', [AssetsController::class, 'view_varaint_asset']);
    

    Route::post('/admin/assets/update/submit', [AssetsController::class, 'update_submit']);


    Route::post('/admin/assets/staff/delete/submit', [AssetsController::class, 'staff_delete_submit']);

    Route::post('/admin/assets/restore', [AssetsController::class, 'restore']);


    
    Route::get('/admin/assets/change/log/{page}', [ChangeLogController::class, 'ChangeLog']);
        
    Route::get('/admin/transfer/add', [TransferController::class, 'add_transfer']);
    
    Route::get('/admin/transfer/add/assets_id={id}', [TransferController::class, 'add_transfer_detail']);
    

    Route::get('/quick/data/{page}', [QuickDataController::class, 'control_quick_data']);

    
    Route::post('/quick/data/add', [QuickDataController::class, 'add_submit_quick_data']);

    Route::post('/admin/quick/data/delete/submit', [QuickDataController::class, 'delete_quick_data']);
    
    Route::post('/admin/quick/data/update/submit', [QuickDataController::class, 'update_quick_data']);

    Route::get('/admin/qr/code/print/assets={assets}', [AssetsController::class, 'print_qr']);

    
    Route::post('/admin/qr/code/print/assets', [AssetsController::class, 'multi_print']); 

    
    Route::post('/admin/export/excel/assets', [AssetsController::class, 'multi_export']); 

    
});


Route::get('/admin/user/add', [UserController::class, 'add_user']);




Route::get('/admin/user/update/id={id}', [UserController::class, 'update_user']);
Route::POST('/admin/user/add/submit', [UserController::class, 'add_submit']);
Route::get('/admin/user/list', [UserController::class, 'list_user']);
Route::post('/admin/user/delete/submit', [UserController::class, 'delete_user']);
Route::post('/admin/user/update/submit', [UserController::class, 'update_user_submit']);
