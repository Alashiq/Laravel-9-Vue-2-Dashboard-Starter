<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;


class TeacherController extends Controller
{


    // Teacher List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = Teacher::latest()
            ->where('state', '<>', 9)
                ->where('name', 'like', '%' . $request->name . '%') 
->where('school', 'like', '%' . $request->school . '%') 

            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي معلمين في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المعلمين بنجاح', 'data' => $list], 200);
    }


    // Get Teacher By Id
    public function show($id)
    {
        $item = Teacher::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه المعلم غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب المعلم بنجاح', 'data' => $item], 200);
    }



    // Delete Teacher
    public function delete($id)
    {
        $item = Teacher::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه المعلم غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا المعلم بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit Teacher
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = Teacher::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' المعلم غير موجود'], 204);

        if ($request['name'] != null) 
$item->name = $request['name']; 

if ($request['age'] != null) 
$item->age = $request['age']; 

if ($request['school'] != null) 
$item->school = $request['school']; 

if ($request['class_id'] != null) 
$item->class_id = $request['class_id']; 



        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث المعلم بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Add New Teacher
    public function create(Request $request)
    {
        $newItem = Teacher::create([
            'name' => $request['name'], 
'age' => $request['age'], 
'school' => $request['school'], 
'class_id' => $request['class_id'], 

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا المعلم بنجاح'], 200);
    }

}
