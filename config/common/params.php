<?php

return [
    'user' => [
        'sign-in' => [
            'max-fail-auth-count' => 10,
            'remember-me-seconds' => 7 * 24 * 60 * 60,
            'auth-key-secret' => '651ERFds1ERG',
            'redirect-route' => ['/user/news/list', 'feed_id' => '', 'page' => 1],
        ]
    ],
    'news' => [
        'max-count' => 100
    ],
    'i18n' => [
        'available-languages' => ['en' => 'en-US', 'ru' => 'ru-RU'],
        'default-language' => 'en',
    ]
];