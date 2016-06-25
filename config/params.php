<?php

return [
    'user' => [
        'sign-in' => [
            'max-fail-auth-count' => 10,
            'remember-me-seconds' => 7 * 24 * 60 * 60,
            'auth-key-secret' => '651ERFds1ERG',
            'redirect-route' => ['/user/news/list', 'feed_id' => '', 'page' => 1],
        ]
    ]
];
