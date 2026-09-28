<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('employe.login');
        }

        return $next($request);
    }

}
