<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserSecurityModel;

class ResetPasswordForm extends UserSecurityModel
{
    const SCENARIO_RESET_PASSWORD = 'reset-password';

    public $newPassword, $repeatPassword;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_RESET_PASSWORD;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_RESET_PASSWORD => ['hash_id', 'reset_password_hash', 'newPassword', 'repeatPassword']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['reset_password_hash', 'required'],
            ['reset_password_hash', 'validateResetPasswordHash'],

            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 3, 'max' => 255],

            ['repeatPassword', 'required', 'message' => \Yii::t('guest', 'Repeat password')],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword',
                'message' => \Yii::t('guest', 'Filled passwords is not equal')],
        ]);
    }

    public function validateResetPasswordHash($attribute, $params) {
        if(!$this->hasErrors() && !$this->user) {
            $this->addError($attribute, \Yii::t('guest', 'Link for password reset is not correct'));
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'newPassword' => \Yii::t('guest', 'New password'),
            'repeatPassword' => \Yii::t('guest', 'Repeat a new password'),
        ]);
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function changePassword() {
        if($this->validate()
        && $this->changeUserPassword()
        && $this->setHashToNull()
        && $userRedirect = $this->getUserModel()->signIn()) {
            return $userRedirect;
        } else {
            return false;
        }
    }

    private function changeUserPassword() {
        $userModel = $this->getUserModel();
        $userModel->password = $this->newPassword;
        return $userModel->save();
    }

    private function setHashToNull() {
        $this->reset_password_hash = null;
        return $this->save(false);
    }
}