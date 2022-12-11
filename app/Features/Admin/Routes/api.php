<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\Admin\Controllers\AuthController;


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
        }
    );
    # # # # # # # # # # # # # # # End Admin Auth # # # # # # # # # # # # # # # 

        # # # # # # # # # # # # # # # Admin Auth # # # # # # # # # # # # # # # 
        Route::group(
            ['prefix' => 'hello'],
            function () {
                Route::get('/', [AuthController::class, 'hello'])->middleware('check.role:ReadMessage');
            }
        );
        # # # # # # # # # # # # # # # End Admin Auth # # # # # # # # # # # # # # # 

});