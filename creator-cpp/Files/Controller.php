<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\xmodel;
use Illuminate\Http\Request;


class xmodelController extends Controller
{


    // xmodel List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = xmodel::latest()
            ->where('state', '<>', 9)
                //xSearchColumn
            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي xarabic في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  الxarabic بنجاح', 'data' => $list], 200);
    }


    // Get xmodel By Id
    public function show($id)
    {
        $item = xmodel::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الxsinglearabic غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب الxsinglearabic بنجاح', 'data' => $item], 200);
    }



    // Delete xmodel
    public function delete($id)
    {
        $item = xmodel::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الxsinglearabic غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الxsinglearabic بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit xmodel
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = xmodel::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' الxsinglearabic غير موجود'], 204);

        //xEditColumn

        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث الxsinglearabic بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // Data For New
    public function new()
    {
        return response()->json(['success' => true, 'message' => 'تم جلب البيانات بنجاح'], 200);
    }


    // Add New xmodel
    public function create(Request $request)
    {
        $newItem = xmodel::create([
            //xInserColumn
        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الxsinglearabic بنجاح'], 200);
    }

}