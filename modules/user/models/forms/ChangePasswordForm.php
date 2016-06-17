<?php

namespace app\modules\user\models\forms;

use app\modules\common\models\db\UserModel;

class ChangePasswordForm extends UserModel
{
    const SCENARIO_CHANGE_PASSWORD = 'change-password';

    public $currentPassword, $newPassword, $repeatPassword;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CHANGE_PASSWORD;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CHANGE_PASSWORD => ['currentPassword', 'newPassword', 'repeatPassword']
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['currentPassword', 'required'],
            ['currentPassword', 'validateCurrentPassword'],

            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 3, 'max' => 255],
            ['newPassword', 'validateNewPasswordEquivalent'],

            ['repeatPassword', 'required'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword',
                'message' => 'Введенные пароли не совпадают'],
        ]);
    }

    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors() && !\Yii::$app->security->validatePassword($this->currentPassword, $this->password)) {
            $this->addError($attribute, 'Текущий пароль не верный');
        }
    }

    public function validateNewPasswordEquivalent($attribute, $params)
    {
        if (!$this->hasErrors() && \Yii::$app->security->validatePassword($this->newPassword, $this->password)) {
            $this->addError($attribute, 'Новый пароль совпадает с текущим');
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'currentPassword' => 'Текущий пароль',
            'newPassword' => 'Новый пароль',
            'repeatPassword' => 'Повторите новый пароль'
        ]);
    }

    public function changePassword() {
        return $this->validate()
        && $this->setNewPassword()
        && $this->sendEmailNotification();
    }

    private function setNewPassword() {
        $this->password = $this->newPassword;
        return $this->save(false);
    }

    private function sendEmailNotification() {
        /** @var $this UserModel */
        return $this->sendMail(
            'password-changed-notify',
            'Ваш пароль был изменен'
        );
    }
}