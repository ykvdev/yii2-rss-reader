<?php

namespace app\modules\common\models\db;

trait UserModelServiceTrait
{
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