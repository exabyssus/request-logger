<?php

namespace Mungurs\AdminLog\Middleware;

use Closure;
use Mungurs\AdminLog\Models\AdminLog;
use Sentinel;
use Illuminate\Http\Request;

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

    public function handle(Request $request, Closure $next)
    {

        $logItem = new AdminLog();
        $user = Sentinel::getUser();

        //TODO: save all data
        //TODO: hide sensitive data $hideFields
        //TODO: add cron and config for cleaning request log table
        //TODO: add readme with setup info
        //TODO: move to correct package namespace

        $logItem->fill(
            [
                'user_name' => $user ? $user->getUserLogin() : null,
                'request_uri' => $request->getUri(),
                'ip' => $request->getClientIp()
            ]
        );
        $logItem->save();

        return $next($request);
    }
}
