<?php
namespace Mungurs\AdminLog\Models;

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
        'ip',
        'forwarded_ip',
        'request_method',
        'request_uri',
        'user_agent',
        'http_referer',
        'http_cookie'
    ];
}