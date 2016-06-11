<?php

return [
    /**
     * COMMON MODULE
     */
    'error' => 'common/common/error',
    'page/<view:[a-zA-Z0-9-]+>' => 'common/common/page',
    'confirmation-email/<email:.*>/<hash:.*>' => 'common/user/confirmation-email',

    /**
     * GUEST MODULE
     */
    'sign-up' => 'guest/guest/sign-up',
    'sign-in' => 'guest/guest/sign-in',
    'resend-confirmation-mail/<email:.*>' => 'guest/guest/resend-confirmation-mail',

    /**
     * USER MODULE
     */
    'news' => 'user/news/list',
    'sign-out' => 'user/user/sign-out',
];