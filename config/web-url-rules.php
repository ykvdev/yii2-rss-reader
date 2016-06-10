<?php

return [
    /**
     * COMMON MODULE
     */
    'error' => 'common/common/error',
    'page/<view:[a-zA-Z0-9-]+>' => 'common/common/page',
    'email-confirmation/<email:.*>/<hash:.*>' => 'common/user/confirmation',

    /**
     * GUEST MODULE
     */
    'sign-up' => 'guest/guest/sign-up',
    'sign-in' => 'guest/guest/sign-in',
    'resend-confirm-mail/<email:.*>' => 'guest/guest/resend-confirm-mail',

    /**
     * USER MODULE
     */
    'news' => 'user/news/list',
    'sign-out' => 'user/user/sign-out',
];