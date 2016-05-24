<?php

return [
    'controllerNamespace' => 'app\modules\common\controllers',

    'layout' => Yii::$app->user->isGuest
        ? '@app/modules/guest/views/layouts/guest'
        : '@app/modules/user/views/layouts/user',
];