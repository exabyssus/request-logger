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
    ]
];