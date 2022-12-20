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

class PermissionController extends Controller
{


    // All Permission
    public function index(Request $request)
    {

        if ($request->count)
            $count = $request->count;
        else
            $count = 10;


        $permissions = Permission::latest()
            ->where('state', '<>', 9)
            ->where('name', 'like', '%' . $request->name . '%')->reorder()->orderBy('id', 'asc')
            ->withCount('admins')
            ->paginate($count);
        if ($permissions->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي مشرفين في الموقع', 'data' => $permissions], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  المشرفين بنجاح', 'data' => $permissions], 200);
    }



}