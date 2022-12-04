<?php

namespace App\Features\App\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    // GET Messages API =>Auth
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'تم جلب الرسائل بنجاح'], 200);
    }



}
