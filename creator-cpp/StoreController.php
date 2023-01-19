<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class Storeontroller extends Controller
{


    // Store List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = Store::latest()
            ->where('id', '<>', $request->user()->id)
            ->where('state', '<>', 9)
            ->where('name', 'like', '%' . $request->name . '%')

            ->paginate($count);

        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مشرفين في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المشرفين بنجاح', 'data' => $list], 200);
    }

    // Get Store By Id
    public function show($id)
    {
        $item = Store::with('role:id,name')->where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب المشرف بنجاح', 'data' => $item], 200);
    }



    // Delete Store
    public function delete($id)
    {
        $item = Store::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);


        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الحساب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }








    // Add New Store
    public function create(Request $request)
    {
        $newItem = Store::create([
            'name' => $request['name'],
            'address' => $request['address'],
        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الحساب بنجاح'], 200);
    }

}