<?php

namespace Arbory\AdminLog\Http\Middleware;

use Cartalyst\Sentinel\Sentinel;
use Closure;
use Arbory\AdminLog\Models\AdminLog;
use Arbory\AdminLog\Utils\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LogAdminRequests
{
    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * The names of the attributes
     * that should not be trimmed.
     *
     * @var array
     */
    protected $hideFields = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Sentinel $sentinel
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
        $this->config = config('admin-log');
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sanitizer = new Sanitizer();
        $user = $this->sentinel->getUser();

        AdminLog::create([
            'user_name' => $user ? $user->getUserLogin() : null,
            'request_uri' => $sanitizer->sanitize($request->getUri()),
            'ip' => $request->getClientIp(),
            'ips' => join(',', $request->ips()),
            'request_method' => $request->getRealMethod(),
            'http_referer' => join(',', Arr::wrap($request->header('HTTP_REFERER', null))),
            'user_agent' => $request->userAgent(),
            'http_content_type' => $request->getContentType(),
            'http_cookie' => serialize($sanitizer->sanitize($request->cookies->all())),
            'session' => serialize($sanitizer->sanitize($this->getSession())),
            'content' => serialize($sanitizer->sanitize($request->all())),
        ]);

        return $next($request);
    }

    /**
     * @return array
     */
    private function getSession()
    {
        $session = request()->session()->all();

        return collect($session)
            ->except($this->config['session_blacklist_keys'])
            ->toArray();
    }

}
