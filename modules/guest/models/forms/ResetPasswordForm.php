<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;

class ResetPasswordForm extends UserModel
{
    const SCENARIO_RESET_PASSWORD = 'reset-password';

    public $hash, $repeatPassword;

    protected $skipFieldsForPopulate = ['password'];

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_RESET_PASSWORD;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RESET_PASSWORD => ['email', 'hash', 'password', 'repeatPassword']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],

            ['hash', 'required'],
            ['hash', 'validateHash'],

            ['repeatPassword', 'required', 'message' => 'Повторите пароль'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password',
                'message' => 'Введенные пароли не совпадают'],
        ]);
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors() && !$this->id) {
            $this->addError($attribute, 'Такой e-mail адрес не найден');
        }
    }

    public function validateHash($attribute, $params) {
        if(!$this->hasErrors() && $this->hash !== $this->getUserSecurityModel()->reset_password_hash) {
            $this->addError($attribute, 'Ссылка смены пароля не верная');
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'password' => 'Новый пароль',
            'repeatPassword' => 'Повторите новый пароль',
        ]);
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function changePassword() {
        if($this->validate()
        && $this->save()
        && $this->setHashToNull()
        && $userRedirect = $this->signIn()) {
            return $userRedirect;
        } else {
            return false;
        }
    }

    private function setHashToNull() {
        $securityModel = $this->getUserSecurityModel();
        $securityModel->reset_password_hash = null;
        return $securityModel->save();
    }
}