<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechController extends Controller
{

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }
}
