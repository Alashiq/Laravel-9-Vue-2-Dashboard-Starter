<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
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
            ->where('phone', 'like', '%'.$request->phone.'%')
            ->where('first_name', 'like', '%'.$request->first_name.'%')
            ->where('last_name', 'like', '%'.$request->last_name.'%')
            ->paginate($count);
        } else {
            $admins = Admin::latest()
            ->where('id', '<>', $request->user()->id)
            ->where('state', '<>', 9)
            ->where('phone', 'like', '%'.$request->phone.'%')
            ->where('first_name', 'like', '%'.$request->first_name.'%')
            ->where('last_name', 'like', '%'.$request->last_name.'%')
            ->paginate($count);
        }
        if ($admins->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مشرفين في الموقع', 'data' => $admins], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المشرفين بنجاح', 'data' => $admins], 200);
    }



}