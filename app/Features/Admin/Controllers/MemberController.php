<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{


    // Member List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = Member::latest()
            ->where('state', '<>', 9)
                ->where('first_name', 'like', '%' . $request->first_name . '%') 
->where('last_name', 'like', '%' . $request->last_name . '%') 
->where('age', 'like', '%' . $request->age . '%') 

            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي أعضاء في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  الأعضاء بنجاح', 'data' => $list], 200);
    }


    // Get Member By Id
    public function show($id)
    {
        $item = Member::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه العضو غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب العضو بنجاح', 'data' => $item], 200);
    }



    // Delete Member
    public function delete($id)
    {
        $item = Member::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه العضو غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا العضو بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit Member
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = Member::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' العضو غير موجود'], 204);

        if ($request['first_name'] != null) 
$item->first_name = $request['first_name']; 

if ($request['last_name'] != null) 
$item->last_name = $request['last_name']; 

if ($request['age'] != null) 
$item->age = $request['age']; 



        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث العضو بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Add New Member
    public function create(Request $request)
    {
        $newItem = Member::create([
            'first_name' => $request['first_name'], 
'last_name' => $request['last_name'], 
'age' => $request['age'], 

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا العضو بنجاح'], 200);
    }

}
