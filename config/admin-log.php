<?php

return [
    'sanitizer' => [
        'sensitive_string_identifiers' => [
            'XSRF-TOKEN',
            config('session.cookie'),
            'password'
        ],
        'sensitive_key_patterns' => [
            '(\S*)password(\S*).*',
        ],
        'removed_value_notification' => 'value_removed_by_admin_log'
    ],
    'cleanup' => [
        'retain_for_days' => 365,
    ],
    /**
     * Session keys to exclude from session field when saving request to db
     */
    'session_blacklist_keys' => [],
];
