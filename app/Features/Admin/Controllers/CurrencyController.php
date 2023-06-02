<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;


class CurrencyController extends Controller
{


    // Currency List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = Currency::latest()
            ->where('state', '<>', 9)
                ->where('name', 'like', '%' . $request->name . '%') 
->where('abbreviation', 'like', '%' . $request->abbreviation . '%') 

            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي عملات في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  العملات بنجاح', 'data' => $list], 200);
    }


    // Get Currency By Id
    public function show($id)
    {
        $item = Currency::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه العملة غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب العملة بنجاح', 'data' => $item], 200);
    }



    // Delete Currency
    public function delete($id)
    {
        $item = Currency::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه العملة غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا العملة بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit Currency
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = Currency::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' العملة غير موجود'], 204);

        if ($request['name'] != null) 
$item->name = $request['name']; 

if ($request['abbreviation'] != null) 
$item->abbreviation = $request['abbreviation']; 



        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث العملة بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // Data For New
    public function new()
    {
        return response()->json(['success' => true, 'message' => 'تم جلب البيانات بنجاح'], 200);
    }


    // Add New Currency
    public function create(Request $request)
    {
        $newItem = Currency::create([
            'name' => $request['name'], 
'abbreviation' => $request['abbreviation'], 

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا العملة بنجاح'], 200);
    }

}
