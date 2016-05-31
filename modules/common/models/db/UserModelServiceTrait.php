<?php

namespace app\modules\common\models\db;

trait UserModelServiceTrait
{
    /**
     * @param string $email
     * @param string $password
     * @return bool|UserModel
     * @throws \yii\base\Exception
     */
    public static function signUp($email, $password) {
        $user = new UserModel;
        $user->email = $email;
        $user->password = \Yii::$app->security->generatePasswordHash($password);
        $user->registered_at = date('Y-m-d H:i:s');
        if(!$user->save()) {
            return false;
        }

        return $user;
    }

    public function sendMail($view, $subject) {
        self::sendMailTo($view, $subject, $this->email);
    }

    public static function sendMailTo($view, $subject, $recipientEmail, $recipientName = null) {
        // Set layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = $recipientName;
        }

        \Yii::$app->mailer->compose([
            'html' => 'views/' . $view . '-html',
            'text' => 'views/' . $view . '-text'
        ])->setTo($recipientName ? [$recipientEmail => $recipientName] : $recipientEmail)
            ->setSubject($subject)
            ->send();

        // Reset layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = null;
        }
    }
}