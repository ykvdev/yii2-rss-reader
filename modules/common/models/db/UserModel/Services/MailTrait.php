<?php

namespace app\modules\common\models\db\UserModel\services;

use app\modules\common\models\db\UserModel;

trait MailTrait
{
    /**
     * @param string $view
     * @param string $subject
     * @param array $params
     * @return bool
     */
    public function sendMail($view, $subject, $params = []) {
        /** @var $this UserModel */
        return self::sendMailTo($view, $subject, $this->email, null, $params);
    }

    /**
     * @param string $view
     * @param string $subject
     * @param string $recipientEmail
     * @param null|string $recipientName
     * @param array $params
     * @return bool
     */
    public static function sendMailTo($view, $subject, $recipientEmail, $recipientName = null, $params = []) {
        \Yii::$app->mailer->setViewPath('@app/modules/common/mail/' . \Yii::$app->language);

        // Set layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = $recipientName;
        }

        $moduleViewsPath = '@app/modules/' . \Yii::$app->controller->module->id . '/mail/' . \Yii::$app->language . '/views';
        $result = \Yii::$app->mailer->compose([
            'html' => $moduleViewsPath . '/' . $view . '-html',
            'text' => $moduleViewsPath . '/' . $view . '-text',
        ], $params)->setTo($recipientName ? [$recipientEmail => $recipientName] : $recipientEmail)
            ->setSubject($subject)
            ->send();

        // Reset layout params
        if($recipientName) {
            \Yii::$app->mailer->getView()->params['name'] = null;
        }

        return $result;
    }
}