<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\App\Controllers\HomeController;



// Route::prefix('app')->group(function () {

    Route::get('/', [HomeController::class, 'index']);

    // Route::get('/', function (Request $request) {
    //     return response()->json(["success" => false, "message" => "انت لم تسجل دخولك أو انتهت الجلسة الخاصة بك"], 401);
    // });

// });
