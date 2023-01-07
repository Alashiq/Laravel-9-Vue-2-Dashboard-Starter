<?php

namespace App\Features\Admin\Controllers;

use App\Features\Admin\Requests\PermissionStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Features\Admin\Resources\PermissionResource;

use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{




    // Get Data Number
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'ليس لديك الصلاحية للقيام بهذه المهمة', 'data' => [
            'users'=>20,
            'roles'=>30,
        ]
    ], 200);

    }




}