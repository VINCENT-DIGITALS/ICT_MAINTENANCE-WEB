<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has Super Administrator role
        if (Auth::check() && optional(Auth::user()->role)->role_name === 'Super Administrator') {
            return $next($request);
        }

        // If not, redirect to dashboard with an error message
        return redirect('/dashboard')->with('error', 'Access denied. You must be a Super Administrator to access this page.');
    }
}

