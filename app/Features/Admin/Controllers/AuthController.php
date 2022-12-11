<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Features\Admin\Resources\AdminResource;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    // Login Admin
    public function login(Request $request)
    {
        $admin = Admin::with('role')->where('phone', $request->phone)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {

            return response()->json(['success' => false, 'message' => 'إسم المستخدم أو كلمة المرور غير صحيحة'], 401);
        }

        if ($admin->state == 0) {
            return response()->json(['success' => false, 'message' => 'هذا الحساب غير مفعل قم بالتواصل مع المسؤول لتفعيل حسابك'], 400);
        } elseif ($admin->state == 2)
            return response()->json(['success' => false, 'message' => 'هذا الحساب محظور ولا يمكن استخدامه مجددا'], 400);

        $admin->token = $admin->createToken('website', ['role:admin'])->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'admin' => new AdminResource($admin),
        ]);
    }

    // Auth Admin
    public function auth(Request $request)
    {
        $request->user()->token = $request->bearerToken();
        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'admin' => new AdminResource($request->user()),
        ]);
    }

    // Add New Admin
    public function store(Request $request)
    {
        if (
            Validator::make($request->all(), [
                'phone' => 'unique:admins',
            ])->fails()
        ) {
            return response()->json(["success" => false, "message" => "اسم الدخول محجوز مسبقا"], 400);
        }
        $admin = Admin::create([
            'phone' => $request['phone'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'role_id' => $request['role_id'],
            'password' => Hash::make($request['password']),
        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الحساب بنجاح'], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(["success" => true, "message" => "تم تسجيل الخروج بنجاح"]);
    }

    // Test Role
    public function hello(Request $request)
    {
        return response()->json(["success" => true, "message" => "تجربة الصلاحيات"]);
    }


    // -- TODO : Add Change Passowrd
    public function editPassword(Request $request)
    {
        if ($request->old_password && $request->new_password) {
            if (!Hash::check($request->old_password, $request->user()->password)) {
                return response()->json(['success' => false, 'message' => 'كلمة المرور القديمة غير صحيحة'], 400);
            }
            $request->user()->password = Hash::make($request->new_password);
            $request->user()->save();
            return response()->json(["success" => true, "message" => "تم تغيير كلمة المرور بنجاح"], 200);
        } else {
            return response()->json(["success" => false, "message" => "لم تقم بإرسال اي حقول لتعديلها"], 400);
        }
    }

    // -- TODO : Add Change Name
    public function editName(Request $request)
    {
        if ($request->first_name && $request->last_name) {
            $request->user()->update($request->only(
                "first_name",
                "last_name",
            )
            );
            return response()->json([
                "success" => true,
                "message" => "تم تحديث الإسم بنجاح",
                "user" => [
                    "first_name" => $request->user()->first_name,
                    "last_name" => $request->user()->last_name,
                ]
            ]);
        } else {
            return response()->json(["success" => false, "message" => "لم تقم بإدخال الاسم واللقب"], 400);
        }
    }

// -- TODO : Add Change Photo

}