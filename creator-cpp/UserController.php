<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Userontroller extends Controller
{


    // User List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = User::latest()
            ->where('state', '<>', 9)
                ->where('first_name', 'like', '%' . $request->first_name . '%') 
->where('middle_name', 'like', '%' . $request->middle_name . '%') 
->where('last_name', 'like', '%' . $request->last_name . '%') 
->where('job', 'like', '%' . $request->job . '%') 

            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مستخدمين في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المستخدمين بنجاح', 'data' => $list], 200);
    }


    // Get User By Id
    public function show($id)
    {
        $item = User::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه المستخدم غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب المستخدم بنجاح', 'data' => $item], 200);
    }



    // Delete User
    public function delete($id)
    {
        $item = User::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه المستخدم غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا المستخدم بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit User
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = User::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' المستخدم غير موجود'], 204);


        if ($request['first_name'] != null) 
$item->first_name = $request['first_name']; 

if ($request['middle_name'] != null) 
$item->middle_name = $request['middle_name']; 

if ($request['last_name'] != null) 
$item->last_name = $request['last_name']; 

if ($request['age'] != null) 
$item->age = $request['age']; 

if ($request['role_id'] != null) 
$item->role_id = $request['role_id']; 

if ($request['job'] != null) 
$item->job = $request['job']; 



        if ($request['type'] != null)
            $item->type = $request['type'];

        if ($request['name'] != null)
            $item->name = $request['name'];

        if ($request['fahter_name'] != null)
            $item->fahter_name = $request['fahter_name'];

        if ($request['manager_name'] != null)
            $item->manager_name = $request['manager_name'];

        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث المستخدم بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Add New User
    public function create(Request $request)
    {
        $newItem = User::create([
            'first_name' => $request['first_name'], 
'middle_name' => $request['middle_name'], 
'last_name' => $request['last_name'], 
'age' => $request['age'], 
'role_id' => $request['role_id'], 
'job' => $request['job'], 

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا المستخدم بنجاح'], 200);
    }

}
