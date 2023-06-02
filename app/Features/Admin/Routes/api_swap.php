<?php

use App\Features\Admin\Controllers\HomeController;
use App\Features\Admin\Controllers\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Features\Admin\Controllers\AuthController;
use App\Features\Admin\Controllers\AdminController;




 use App\Features\Admin\Controllers\CurrencyController; 


 use App\Features\Admin\Controllers\BankAccountController; 


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



# # # # # # # # # # # # # # # # #  currencies  # # # # # # # # # # # # # # # # #
Route::controller(CurrencyController::class)->prefix('currency')->group( 
function () { 
Route::get('/', [CurrencyController::class, 'index'])->middleware('check.role:ReadCurrency'); 
Route::delete('/{id}', [CurrencyController::class, 'delete'])->middleware('check.role:DeleteCurrency');
Route::get('/new', [CurrencyController::class, 'new'])->middleware('check.role:CreateCurrency'); 
Route::get('/{id}', [CurrencyController::class, 'show'])->middleware('check.role:ReadCurrency'); 
Route::put('/{id}', [CurrencyController::class, 'edit'])->middleware('check.role:EditCurrency'); 
Route::post('/', [CurrencyController::class, 'create'])->middleware('check.role:CreateCurrency'); 
} 
); 
# # # # # # # # # # # # # # # # # End currencies  # # # # # # # # # # # # # # #  
 
# # # # # # # # # # # # # # # # #  bank_accounts  # # # # # # # # # # # # # # # # #
Route::controller(BankAccountController::class)->prefix('bankaccount')->group( 
function () { 
Route::get('/', [BankAccountController::class, 'index'])->middleware('check.role:ReadBankAccount'); 
Route::delete('/{id}', [BankAccountController::class, 'delete'])->middleware('check.role:DeleteBankAccount'); 
Route::get('/new', [BankAccountController::class, 'new'])->middleware('check.role:CreateBankAccount'); 
Route::get('/{id}', [BankAccountController::class, 'show'])->middleware('check.role:ReadBankAccount'); 
Route::put('/{id}', [BankAccountController::class, 'edit'])->middleware('check.role:EditBankAccount'); 
Route::post('/', [BankAccountController::class, 'create'])->middleware('check.role:CreateBankAccount'); 
} 
); 
# # # # # # # # # # # # # # # # # End bank_accounts  # # # # # # # # # # # # # # #  
 
#xRoute 
 
 


});
