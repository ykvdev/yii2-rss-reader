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

    public function beforeValidate() {
        if(!parent::beforeValidate()) {
            return false;
        }

        if($this->email && !$this->id && $user = self::findOne(['email' => $this->email])) {
            $this->populateRecord($this, $user->toArray());
        }

        return true;
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors() && !$this->id) {
            $this->addError($attribute, 'Такой e-mail адрес не найден');
        }
    }

    public function validateEmailConfirmed($attribute, $params) {
        if(!$this->hasErrors() && $this->confirmed) {
            $this->addError($attribute, 'Этот e-mail адрес уже подтвержден');
        }
    }

    /**
     * @return bool
     */
    public function resendConfirmationMail() {
        return $this->validate()
        && $this->sendMail(
            'confirmation',
            'Подтверждение e-mail адреса',
            ['link' => $this->getConfirmationLink()]
        );
    }
}