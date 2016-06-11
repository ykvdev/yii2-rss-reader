<?php

namespace app\modules\common\models\forms;

use app\modules\common\models\db\UserModel;

class ConfirmationForm extends UserModel
{
    const SCENARIO_CONFIRMATION_EMAIL = 'confirmation-email';

    /** @var string */
    public $hash;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CONFIRMATION_EMAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CONFIRMATION_EMAIL => ['email', 'hash']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],

            ['hash', 'required'],
            ['hash', 'validateHash'],
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
        if(!$this->hasErrors()) {
            if(!$this->id) {
                $this->addError($attribute, 'Такой e-mail адрес не найден');
            }
        }
    }

    public function validateHash($attribute, $params) {
        if(!$this->hasErrors() && !$this->validateConfirmationHash($this->hash)) {
            $this->addError($attribute, 'Ссылка подтверждения e-mail адреса не верная');
        }
    }

    /**
     * @return bool
     */
    public function confirm() {
        if(!$this->validate()) {
            return false;
        }

        if(!$this->confirmed) {
            $this->confirmed = 1;
            return $this->save();
        } else {
            return true;
        }
    }
}