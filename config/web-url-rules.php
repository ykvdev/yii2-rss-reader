<?php

return [
    /**
     * COMMON MODULE
     */
    'error' => 'common/common/error',
    'page/<view:[a-zA-Z0-9-]+>' => 'common/common/page',
    'confirmation-email/<hash_id:.*>/<confirmation_hash:.*>' => 'common/user/confirmation-email',

    /**
     * GUEST MODULE
     */
    'sign-up' => 'guest/guest/sign-up',
    'sign-in' => 'guest/user/sign-in',
    'resend-confirmation-mail/<email:.*>' => 'guest/user/resend-confirmation-mail',
    [
        'pattern' => 'reset-password-request/<email:.*>',
        'route' => 'guest/user/reset-password-request',
        'defaults' => ['email' => '']
    ],
    'reset-password/<hash_id:.*>/<reset_password_hash:.*>' => 'guest/user/reset-password',

    /**
     * USER MODULE
     */
    'news' => 'user/news/list',
    'change-email' => 'user/user/change-email',
    'change-password' => 'user/user/change-password',
    'sign-out' => 'user/user/sign-out',
];