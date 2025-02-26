<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthResponses
{
    public static function login(Request $request)
    {
        return view('auth.login');
    }

    public static function register(Request $request)
    {
        return view('auth.register');
    }

    public static function passwordReset(Request $request)
    {
        return view('auth.passwords.reset');
    }

    public static function passwordEmail(Request $request)
    {
        return view('auth.passwords.email');
    }
}
