<?php

namespace Mungurs\AdminLog\Middleware;

use Closure;

class LogAdminRequests
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $hideFields = [
        'password',
        'password_confirmation',
    ];

    public function handle($request, Closure $next)
    {


        return $next($request);
    }
}
