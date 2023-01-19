<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class Userontroller extends Controller
{


    // User List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        if ($request->state != "null") {
            $list = User::latest()
                ->where('id', '<>', $request->user()->id)->where('state', '<>', 9)
                ->where('state', $request->state)
                ->where('phone', 'like', '%' . $request->phone . '%')
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->paginate($count);
        } else {
            $list = User::latest()
                ->where('id', '<>', $request->user()->id)
                ->where('state', '<>', 9)
                ->where('phone', 'like', '%' . $request->phone . '%')
                ->where('first_name', 'like', '%' . $request->first_name . '%')
                ->where('last_name', 'like', '%' . $request->last_name . '%')
                ->paginate($count);
        }
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مشرفين في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المشرفين بنجاح', 'data' => $list], 200);
    }

    // Get User By Id
    public function show($id)
    {
        $item = User::with('role:id,name')->where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب المشرف بنجاح', 'data' => $item], 200);
    }



    // Delete User
    public function delete($id)
    {
        $item = User::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);


        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الحساب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }








    // Add New User
    public function create(Request $request)
    {



        $newItem = User::create([
            'name' => $request['name'],
        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الحساب بنجاح'], 200);
    }

}
