<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies = '*'; // trust all proxies, or set your proxy IPs

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = [
        'X_FORWARDED_FOR',
        'X_FORWARDED_HOST',
        'X_FORWARDED_PROTO',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED_HOST',
        'HTTP_X_FORWARDED_PROTO',
    ];
}
