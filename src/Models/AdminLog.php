<?php

namespace Arbory\AdminLog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package Arbory\Merchant\Models
 * @mixin \Eloquent
 */
class AdminLog extends Model
{
    protected $table = 'admin_log';

    protected $fillable = [
        'user_name',
        'request_uri',
        'ip',
        'ips',
        'request_method',
        'http_referer',
        'user_agent',
        'http_content_type',
        'http_cookie',
        'session',
        'content'
    ];

    public function __toString()
    {
        return $this->user_name;
    }
}