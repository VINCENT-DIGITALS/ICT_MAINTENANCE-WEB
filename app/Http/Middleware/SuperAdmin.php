<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id === 1) { // Assuming 1 is Super Admin role_id
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Unauthorized access');
    }
}
