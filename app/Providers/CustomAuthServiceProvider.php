<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Auth\CustomAuthController;

class CustomAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->singleton('auth.login.response', function () {
            return new class {
                public function toResponse($request)
                {
                    return view('auth.login');
                }
            };
        });
    }
}
