<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;

class ResetPasswordForm extends UserModel
{
    const SCENARIO_RESET_PASSWORD = 'reset-password';

    public $hash, $repassword;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_RESET_PASSWORD;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RESET_PASSWORD => ['email', 'hash', 'password', 'repassword']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],

            ['hash', 'required'],
            ['hash', 'validateHash'],

            ['repassword', 'required', 'message' => 'Повторите пароль'],
            [['password', 'repassword'], 'compare', 'compareAttribute' => 'password',
                'message' => 'Введенные пароли не совпадают'],
        ]);
    }

    public function beforeValidate() {
        if(!parent::beforeValidate()) {
            return false;
        }

        if($this->email && !$this->id && $user = self::findOne(['email' => $this->email])) {
            $this->populateRecord($this, array_merge($user->toArray(), ['password' => null]));
        }

        return true;
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors() && !$this->id) {
            $this->addError($attribute, 'Такой e-mail адрес не найден');
        }
    }

    public function validateHash($attribute, $params) {
        if(!$this->hasErrors() && !$this->hash !== $this->getUserSecurityModel()->reset_password_hash) {
            $this->addError($attribute, 'Ссылка смены пароля не верная');
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'password' => 'Новый пароль',
            'repassword' => 'Повторите новый пароль',
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