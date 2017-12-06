<?php

namespace Mungurs\AdminLog\Middleware;

use Closure;
use Mungurs\AdminLog\Models\AdminLog;
use Mungurs\AdminLog\Utils\Sanitizer;
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

        $sanitizer = new Sanitizer( config('admin-log.sanitizer'));
        $logItem = new AdminLog();
        $user = Sentinel::getUser();
        //TODO: move to correct package namespace

        $logItem->fill(
            [
                'user_name' => $user ? $user->getUserLogin() : null,
                'request_uri' => $sanitizer->sanitize($request->getUri()), // request schema + host + uri
                'ip' => $request->getClientIp(),
                'ips' => join(',', $request->ips()),
                'request_method' => $request->getRealMethod(),
                'http_referer' => join(',', array_wrap($request->header('HTTP_REFERER', null))),
                'user_agent' => $request->userAgent(),
                'http_content_type' => $request->getContentType(),
                'http_cookie' => serialize($sanitizer->sanitize($request->cookies->all())),
                'session' => serialize($sanitizer->sanitize($request->session()->all())),
                'content' => serialize($sanitizer->sanitize($request->getContent())),
            ]
        );
        $logItem->save();

        return $next($request);
    }
}
