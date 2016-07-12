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
                'message' => \Yii::t('user', 'Entered passwords is not equal')],
        ]);
    }

    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors() && !\Yii::$app->security->validatePassword($this->currentPassword, $this->password)) {
            $this->addError($attribute, \Yii::t('user', 'Current password is incorrect'));
        }
    }

    public function validateNewPasswordEquivalent($attribute, $params)
    {
        if (!$this->hasErrors() && \Yii::$app->security->validatePassword($this->newPassword, $this->password)) {
            $this->addError($attribute, \Yii::t('user', 'New password is equal to current'));
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'currentPassword' => \Yii::t('user', 'Current password'),
            'newPassword' => \Yii::t('user', 'New password'),
            'repeatPassword' => \Yii::t('user', 'Repeat a new password')
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
            \Yii::t('user', 'Your password has been changed')
        );
    }
}