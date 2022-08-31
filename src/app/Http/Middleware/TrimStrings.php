<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

final class TrimStrings extends Middleware
{
    /**
     * @var array The names of the attributes that should not be trimmed.
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
