<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Dump and die to inspect the whole input
        // error_log(print_r($request->all(), true));
        // return response()->json($request->all());


        $credentials = $request->only('philrice_id', 'password');
        if (!isset($credentials['password'])) {
            return response()->json(['error' => '    is missing'], 400);
        }
        if (!isset($credentials['philrice_id'])) {
            return response()->json(['error' => 'philrice_id is missing'], 400);
        }

        $user = User::where('philrice_id', $credentials['philrice_id'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('mobile_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }





    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->delete(); // Delete all tokens
        return response()->json(['message' => 'Logged out successfully']);
    }
}
