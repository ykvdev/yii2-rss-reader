<?php

namespace app\controllers\test;

use app\models\db\UsersModel;
use yii\base\Action;

class IndexAction extends Action
{
    public function run() {
        /** @var UsersModel $user */
        $user = UsersModel::findOne(['email' => 'test@mail.com']);
        $user->sendMail('test', 'Test Subject');

        return $this->controller->render('index');
    }
}