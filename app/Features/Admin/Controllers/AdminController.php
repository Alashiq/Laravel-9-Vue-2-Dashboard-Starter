<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{


    // Admin List
    public function index(Request $request)
    {

        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        if ($request->state != "null") {
            $admins = Admin::latest()
                ->where('id', '<>', $request->user()->id)->where('state', '<>', 9)
                ->where('state', $request->state)
                ->where('phone', 'like', '%' . $request->phone . '%')
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->paginate($count);
        } else {
            $admins = Admin::latest()
                ->where('id', '<>', $request->user()->id)
                ->where('state', '<>', 9)
                ->where('phone', 'like', '%' . $request->phone . '%')
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->paginate($count);
        }
        if ($admins->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مشرفين في الموقع', 'data' => $admins], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المشرفين بنجاح', 'data' => $admins], 200);
    }

    // Get Admin By Id
    public function show($admin)
    {
        $admin = Admin::with('role:id,name')->where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
        return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب المشرف بنجاح', 'data' => $admin], 200);
    }

    // Activate Admin
    public function active($admin)
    {
        $admin = Admin::where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);

        if ($admin->state == 1)
            return response()->json(['success' => false, 'message' => 'هذا الحساب مفعل مسبقا'], 400);

        if ($admin->state == 2)
            return response()->json(['success' => false, 'message' => 'هذا الحساب محظور ولا يمكن تفعيله'], 400);
        $admin->state = 1;
        $edit = $admin->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تفعيل هذا الحساب'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // DisActivate Admin
    public function disActive($admin)
    {
        $admin = Admin::where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);

        if ($admin->state == 0)
            return response()->json(['success' => false, 'message' => 'هذا الحساب غير مفعل مسبقا'], 400);

        if ($admin->state == 2)
            return response()->json(['success' => false, 'message' => 'هذا الحساب محظور ولا يمكن تفعيله'], 400);

        $admin->state = 0;
        $edit = $admin->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم إلغاء تفعيل هذا الحساب'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // Banned Admin
    public function banned($admin)
    {
        $admin = Admin::where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);

        if ($admin->state == 2)
            return response()->json(['success' => false, 'message' => 'هذا الحساب محظور مسبقا'], 400);

        $admin->state = 2;
        $edit = $admin->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حظر هذا الحساب ولا يمكنم استخدامه مجددا'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // Delete Admin
    public function delete($admin)
    {
        $admin = Admin::where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);


        $admin->state = 9;
        $edit = $admin->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الحساب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


        // Banned Admin
        public function resetPassword($admin)
        {
            $admin = Admin::where('id', $admin)->where('state', '<>', 9)->first();
            if (!$admin)
                return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
    
            if ($admin->state == 2)
                return response()->json(['success' => false, 'message' => 'هذا الحساب محظور'], 400);
    
            $admin->password =  Hash::make("123456");
            $edit = $admin->save();
            if ($edit)
                return response()->json(['success' => true, 'message' => 'تم تغيير كلمة المرور إلى 123456 , يجب عليك تغيير كلمة المرور بمجرد تسجيل دخول إلى الحساب'], 200);
            return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
        }


            // Get Admin By Id With Permseeions
    public function showWithPermissions($admin)
    {
        $admin = Admin::with('role:id,name')->where('id', $admin)->where('state', '<>', 9)->first();
        if (!$admin)
        return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);


        $roles = Permission::select('id', 'name')->where('state', '<>', 9)->get();
        if (count($roles) == 0)
            return response()->json([], 204);


        return response()->json(['success' => true, 'message' => 'تم جلب المشرف بنجاح', 'data' => $admin,'roles'=>$roles], 200);
    }


        //  Change Admin Role
        public function changeAdminRole($admin, Request $request)
        {
            $admin = Admin::with('role:id,name')->where('id', $admin)->where('state', '<>', 9)->first();
            if (!$admin)
                return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 400);
    
            if (Validator::make($request->all(), [
                'role_id' => 'required',
            ])->fails()) {
                return response()->json(["success" => false, "message" => "يجب عليك إرسال رقم الدور"], 400);
            }
    
            $role = Permission::where('id', $request['role_id'])->where('state', '<>', 9)->first();
            if (!$role)
                return response()->json(['success' => false, 'message' => 'هذا الدور لم يعد متاح قم بإختيار دور اخر'], 400);
    
            $admin->role_id = $request['role_id'];
            $edit = $admin->save();
            if ($edit)
                return response()->json(['success' => true, 'message' => 'تم تحديث دور الحساب بنجاح'], 200);
            return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
        }

}