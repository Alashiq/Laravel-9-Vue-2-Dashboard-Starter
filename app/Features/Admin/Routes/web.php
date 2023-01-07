<?php

use App\Features\Admin\Controllers\HomeController;
use App\Features\Admin\Controllers\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\Admin\Controllers\AuthController;
use App\Features\Admin\Controllers\AdminController;



Route::view('/','admin.admin');
Route::view('/{a?}/{b?}/{c?}/{d?}/{e?}','admin.admin');
