<?php

namespace App\Middlewares;

class Authorized
{
    public function handle()
    {
        if (!auth()->check()) {
            return redirect('/');
        }
    }
}