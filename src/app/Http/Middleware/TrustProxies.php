<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

final class TrustProxies extends Middleware
{
    /**
     * @var array|string The trusted proxies for this application.
     */
    protected $proxies;

    /**
     * @var int The headers that should be used to detect proxies.
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO;
}
