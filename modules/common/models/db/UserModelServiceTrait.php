<?php

namespace app\modules\common\models\db;

use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

trait UserModelServiceTrait
{
    /**
     * @param string $email
     * @param string $password
     * @return UserModel
     * @throws ServerErrorHttpException
     * @throws \yii\base\Exception
     */
    public static function signUp($email, $password) {
        $user = new UserModel;
        $user->email = $email;
        $user->password = \Yii::$app->security->generatePasswordHash($password);
        $user->registered_at = date('Y-m-d H:i:s');
        if(!$user->save()) {
            $errors = $user->getFirstErrors();
            throw new ServerErrorHttpException($errors ? array_shift($errors) : null);
        }

        $user->sendMail('confirmation', 'Подтверждение e-mail адреса', [
            'link' => Url::toRoute(['/user/user/confirmation', 'hash' => $user->getConfirmationHash()], true)
        ]);

        return $user;
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getConfirmationHash() {
        /** @var $this UserModel */
        return \Yii::$app->security->generatePasswordHash($this->email . $this->registered_at . $this->id . $this->email);
    }

    public function sendMail($view, $subject, $params = []) {
        /** @var $this UserModel */
        self::sendMailTo($view, $subject, $this->email, null, $params);
    }

    public static function sendMailTo($view, $subject, $recipientEmail, $recipientName = null, $params = []) {
        // Set layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = $recipientName;
        }

        $moduleViewsPath = '@app/modules/' . \Yii::$app->controller->module->id . '/mail/views';
        \Yii::$app->mailer->compose([
            'html' => $moduleViewsPath . '/' . $view . '-html',
            'text' => $moduleViewsPath . '/' . $view . '-text',
        ], $params)->setTo($recipientName ? [$recipientEmail => $recipientName] : $recipientEmail)
            ->setSubject($subject)
            ->send();

        // Reset layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = null;
        }
    }
}