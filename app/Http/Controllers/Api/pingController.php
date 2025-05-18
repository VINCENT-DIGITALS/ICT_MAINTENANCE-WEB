<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function ping()
    {
        return response()->json([
            'status' => 'ok', 
            'message' => 'API is operational'
        ]);
    }
}