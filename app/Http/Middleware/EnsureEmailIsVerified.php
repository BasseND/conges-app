<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            !$request->user()->hasVerifiedEmail())) {
            return redirect()->route('verification.notice')
                ->with('warning', 'Vous devez vérifier votre adresse email avant d\'accéder à cette page.');
        }

        return $next($request);
    }
}
