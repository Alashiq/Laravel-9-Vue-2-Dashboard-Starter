<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Currency;
use Illuminate\Http\Request;


class BankAccountController extends Controller
{


    // BankAccount List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = BankAccount::latest()
            ->where('state', '<>', 9)
            ->where('name', 'like', '%' . $request->name . '%')
            ->where('branch', 'like', '%' . $request->branch . '%')
            ->where('account_number', 'like', '%' . $request->account_number . '%')

            ->paginate($count);
        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي حسابات في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  الحسابات بنجاح', 'data' => $list], 200);
    }


    // Get BankAccount By Id
    public function show($id)
    {
        $item = BankAccount::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب الحساب بنجاح', 'data' => $item], 200);
    }



    // Delete BankAccount
    public function delete($id)
    {
        $item = BankAccount::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الحساب غير موجود'], 204);
        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الحساب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }




    // Edit BankAccount
    public function edit(Request $request, $id)
    {
        // Check If Role Exist Or Not
        $item = BankAccount::where('id', $id)->where('state', '<>', 9)->first();

        if (!$item)
            return response()->json(['success' => false, 'message' => ' الحساب غير موجود'], 204);

        if ($request['name'] != null)
            $item->name = $request['name'];

        if ($request['branch'] != null)
            $item->branch = $request['branch'];

        if ($request['account_number'] != null)
            $item->account_number = $request['account_number'];

        if ($request['currency_id'] != null)
            $item->currency_id = $request['currency_id'];

        if ($request['name_holder'] != null)
            $item->name_holder = $request['name_holder'];



        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم تحديث الحساب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }


    // Data For New
    public function new ()
    {
        $currencies = Currency::all();
        return response()->json(['success' => true, 'message' => 'تم جلب العملات بنجاح','currencies'=>$currencies], 200);
    }


    // Add New BankAccount
    public function create(Request $request)
    {
        $newItem = BankAccount::create([
            'name' => $request['name'],
            'branch' => $request['branch'],
            'account_number' => $request['account_number'],
            'currency_id' => $request['currency_id'],
            'name_holder' => $request['name_holder'],

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الحساب بنجاح'], 200);
    }

}