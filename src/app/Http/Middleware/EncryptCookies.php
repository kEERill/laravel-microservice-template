<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

final class EncryptCookies extends Middleware
{
    /**
     * @var array The names of the cookies that should not be encrypted.
     */
    protected $except = [
        '_fm_uuid',
        '_fm_search_uuid'
    ];
}
