<?php

namespace app\controllers\test;

use app\models\db\UserModel;
use yii\base\Action;

class IndexAction extends Action
{
    public function run() {
        /** @var UserModel $user */
        $user = UserModel::findOne(['email' => 'test@mail.com']);
        $user->sendMail('test', 'Test Subject');

        return $this->controller->render('index');
    }
}