<?php

namespace app\modules\common\models\db;

use yii\helpers\Url;
use yii\web\Response;
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

        $user->sendMail('confirmation', 'Подтверждение e-mail адреса', ['link' => $user->getConfirmationLink()]);

        return $user;
    }

    /**
     * @return string
     */
    public function getConfirmationLink() {
        /** @var $this UserModel */
        return Url::toRoute([
            '/common/user/confirmation',
            'email' => $this->email,
            'hash' => $this->getConfirmationHash()
        ], true);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getConfirmationHash() {
        /** @var $this UserModel */
        return \Yii::$app->security->generatePasswordHash($this->email . $this->registered_at . $this->id . $this->email);
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function validateConfirmationHash($hash) {
        /** @var $this UserModel */
        return \Yii::$app->security->validatePassword($this->email . $this->registered_at . $this->id . $this->email, $hash);
    }

    /**
     * @param bool|false $rememberMe
     * @param bool|true $withRedirect
     * @return Response|bool
     */
    public function signIn($rememberMe = false, $withRedirect = true) {
        /** @var UserModel $this */
        $auth = \Yii::$app->user->login($this, $rememberMe ? \Yii::$app->params['user']['sign-in']['remember-me-seconds'] : 0);
        if(!$auth) {
            return false;
        }

        if($withRedirect) {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['user']['sign-in']['redirect-route']);
        } else {
            return true;
        }
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