<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // تحديث عمود last_seen بالوقت الحالي
            Auth::user()->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}
