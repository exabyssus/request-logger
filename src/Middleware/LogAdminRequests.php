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
        //TODO: hide sensitive data $hideFields
        //TODO: add cron and config for cleaning request log table
        //TODO: add readme with setup info
        //TODO: move to correct package namespace

        $logItem->fill(
            [
                'user_name' => $user ? $user->getUserLogin() : null,
                'request_uri' => $request->getUri(), // request schema + host + uri
                'ip' => $request->getClientIp(),
                'ips' => join(',', $request->ips()),
                'request_method' => $request->getRealMethod(),
                'http_referer' => join(',', array_wrap($request->header('HTTP_REFERER', null))),
                'user_agent' => $request->userAgent(),
                'http_content_type' => $request->getContentType(),
                'http_cookie' => serialize($request->cookies->all()),
                'session' => serialize($request->session()->all()),
                'content' => serialize($request->getContent()),
            ]
        );
        $logItem->save();

        return $next($request);
    }
}
