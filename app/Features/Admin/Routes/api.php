<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\Admin\Controllers\AuthController;
use App\Features\Admin\Controllers\AdminController;


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


    # # # # # # # # # # # # # # # # #  Admin  # # # # # # # # # # # # # # # # #
    Route::controller(AdminController::class)->prefix('admin')->group(
        function () {
            Route::get('/', [AdminController::class, 'index'])->middleware('check.role:ReadAdmin');
            Route::put('/{admin}/active', [AdminController::class, 'active'])->middleware('check.role:ActiveAdmin');
            Route::put('/{admin}/disActive', [AdminController::class, 'disActive'])->middleware('check.role:DisActiveAdmin');
            Route::delete('/{admin}', [AdminController::class, 'delete'])->middleware('check.role:DeleteAdmin');
            Route::put('/{admin}/banned', [AdminController::class, 'banned'])->middleware('check.role:BannedAdmin');
        }
    );
    # # # # # # # # # # # # # # # # # End Admin  # # # # # # # # # # # # # # # 


    # # # # # # # # # # # # # # # Admin Auth # # # # # # # # # # # # # # # 
    Route::group(
        ['prefix' => 'hello'],
        function () {
            Route::get('/', [AuthController::class, 'hello'])->middleware('check.role:ReadMessage');
        }
    );
    # # # # # # # # # # # # # # # End Admin Auth # # # # # # # # # # # # # # # 

});