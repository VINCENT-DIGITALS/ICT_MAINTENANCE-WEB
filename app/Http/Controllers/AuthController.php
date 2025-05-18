<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'philrice_id' => 'required',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('philrice_id', $request->philrice_id)->first();

        if (!$user) {
            return back()->withErrors(['philrice_id' => 'User not found.']);
        }

        // Debug: Check if password matches
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['philrice_id' => 'Incorrect password.']);
        }

        if (Auth::attempt($credentials)) {
            return Redirect::intended('/dashboard');
        }

        return back()->withErrors(['philrice_id' => 'Authentication failed.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
