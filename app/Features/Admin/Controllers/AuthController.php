<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index()
    {
        return response()->json(['success' => true, 'message' => 'تم Auth الرسائل بنجاح'], 200);
    }

}
