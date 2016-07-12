<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;
use yii\helpers\Url;

class ResetPasswordRequestForm extends UserModel
{
    const SCENARIO_RESET_PASSWORD = 'reset-password';

    public $captcha;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_RESET_PASSWORD;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RESET_PASSWORD => ['email', 'captcha'],
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],

            ['captcha', 'filter', 'filter' => 'trim'],
            ['captcha', 'required', 'message' => \Yii::t('guest', 'Enter controlling digits')],
            ['captcha', 'captcha', 'captchaAction' => Url::toRoute('/common/common/captcha'),
                'message' => \Yii::t('guest', 'Controlling digits is not correct')],
        ]);
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors() && !$this->id) {
            $this->addError($attribute, \Yii::t('guest', 'This e-mail address is not found'));
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'captcha' => \Yii::t('guest', 'Enter controlling digits'),
        ]);
    }

    /**
     * @return bool
     */
    public function sendResetPasswordMail() {
        return $this->validate()
        && $this->generateHash()
        && parent::sendResetPasswordMail();
    }

    private function generateHash() {
        $securityModel = $this->getUserSecurityModel();
        $securityModel->reset_password_hash = md5(time() . mt_rand(0, 100) . uniqid());
        return $securityModel->save();
    }
}