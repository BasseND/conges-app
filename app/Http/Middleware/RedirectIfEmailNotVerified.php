<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfEmailNotVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->hasVerifiedEmail() && 
            !$request->is('email/*', 'logout')) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
