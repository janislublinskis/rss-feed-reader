<?php

namespace App\Middlewares;

class RedirectIfAuthenticated
{
    public function handle()
    {
        if (auth()->check()) {
            return redirect('/');
        }
    }
}