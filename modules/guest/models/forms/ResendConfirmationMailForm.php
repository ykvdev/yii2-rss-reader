<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;

class ResendConfirmationMailForm extends UserModel
{
    const SCENARIO_RESEND_CONFIRMATION_MAIL = 'resend-confirmation-mail';

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_RESEND_CONFIRMATION_MAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RESEND_CONFIRMATION_MAIL => ['email']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],
            ['email', 'validateEmailConfirmed'],
        ]);
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors() && !$this->id) {
            $this->addError($attribute, \Yii::t('guest', 'This e-mail address not found'));
        }
    }

    public function validateEmailConfirmed($attribute, $params) {
        if(!$this->hasErrors() && $this->getUserSecurityModel()->confirmed) {
            $this->addError($attribute, \Yii::t('guest', 'This e-mail address already confirmed'));
        }
    }

    /**
     * @return bool
     */
    public function sendConfirmationMail() {
        return $this->validate() && parent::sendConfirmationMail();
    }
}