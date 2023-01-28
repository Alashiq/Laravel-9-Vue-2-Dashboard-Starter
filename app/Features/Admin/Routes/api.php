<?php

use App\Features\Admin\Controllers\HomeController;
use App\Features\Admin\Controllers\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\Admin\Controllers\AuthController;
use App\Features\Admin\Controllers\AdminController;




 //ximport

# # # # # # # # # # # # # # # Admin Not Auth # # # # # # # # # # # # # # # 
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/signup', 'store');
});

Route::middleware(['auth:sanctum', 'type.admin'])->group(function () {

    # # # # # # # # # # # # # # # Admin Auth # # # # # # # # # # # # # # # 
    Route::group(
        ['prefix' => 'auth'],
        function () {
            Route::get('/auth', [AuthController::class, 'auth']);
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::post('/editName', [AuthController::class, 'editName']);
            Route::post('/editPassword', [AuthController::class, 'editPassword']);
            Route::post('/editPhoto', [AuthController::class, 'editPhoto']);
        }
    );
    # # # # # # # # # # # # # # # End Admin Auth # # # # # # # # # # # # # # # 

    # # # # # # # # # # # # # # # # #  Home  # # # # # # # # # # # # # # # # #
    Route::controller(HomeController::class)->prefix('home')->group(
        function () {
            Route::get('/', [HomeController::class, 'index'])->middleware('check.role:HomeChart');
        }
    );
    # # # # # # # # # # # # # # # # # End Home  # # # # # # # # # # # # # # # 


    # # # # # # # # # # # # # # # # #  Admin  # # # # # # # # # # # # # # # # #
    Route::controller(AdminController::class)->prefix('admin')->group(
        function () {
            Route::get('/', [AdminController::class, 'index'])->middleware('check.role:ReadAdmin');
            Route::get('/{admin}', [AdminController::class, 'show'])->middleware('check.role:ReadAdmin');
            Route::put('/{admin}/active', [AdminController::class, 'active'])->middleware('check.role:ActiveAdmin');
            Route::put('/{admin}/disActive', [AdminController::class, 'disActive'])->middleware('check.role:DisActiveAdmin');
            Route::delete('/{admin}', [AdminController::class, 'delete'])->middleware('check.role:DeleteAdmin');
            Route::put('/{admin}/banned', [AdminController::class, 'banned'])->middleware('check.role:BannedAdmin');
            Route::put('/{admin}/reset', [AdminController::class, 'resetPassword'])->middleware('check.role:ResetPasswordAdmin');
            Route::get('/{admin}/withPermissions', [AdminController::class, 'showWithPermissions'])->middleware('check.role:EditRoleAdmin');
            Route::put('/{admin}/role', [AdminController::class, 'changeAdminRole'])->middleware('check.role:EditRoleAdmin');
            Route::post('/', [AdminController::class, 'create'])->middleware('check.role:CreateAdmin');
        }
    );
    # # # # # # # # # # # # # # # # # End Admin  # # # # # # # # # # # # # # # 


    # # # # # # # # # # # # # # # # #  Admin Permissions  # # # # # # # # # # # # # # # # #
    Route::controller(PermissionController::class)->prefix('permission')->group(
        function () {
            Route::get('/', [PermissionController::class, 'index'])->middleware('check.role:ReadRole');
            Route::get('/allPermissions', [PermissionController::class, 'allPermissions'])->middleware('check.role:ReadAdmin');
            Route::delete('/{role}', [PermissionController::class, 'delete'])->middleware('check.role:DeleteRole');
            Route::get('/{role}', [PermissionController::class, 'show'])->middleware('check.role:ReadRole');
            Route::put('/{role}', [PermissionController::class, 'edit'])->middleware('check.role:EditRole');
            Route::post('/', [PermissionController::class, 'create'])->middleware('check.role:CreateRole');

        }
    );
    # # # # # # # # # # # # # # # # # End Admin Permissions  # # # # # # # # # # # # # # # 



#xRoute 


});
