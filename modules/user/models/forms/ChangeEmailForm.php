<?php

namespace app\modules\user\models\forms;

use app\modules\common\models\db\UserModel;

class ChangeEmailForm extends UserModel
{
    const SCENARIO_CHANGE_EMAIL = 'change-email';

    public $currentPassword;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CHANGE_EMAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CHANGE_EMAIL => ['email', 'currentPassword']
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['email', 'unique', 'targetAttribute' => 'email', 'filter' => ['!=', 'id', \Yii::$app->user->identity->id]],
            ['email', 'validateEmailEquivalent'],

            ['currentPassword', 'required'],
            ['currentPassword', 'validatePassword'],
        ]);
    }

    public function validateEmailEquivalent($attribute, $params) {
        if (!$this->hasErrors() && $this->email === \Yii::$app->user->identity->email) {
            $this->addError($attribute, \Yii::t('user', 'Entered e-mail is equal to current'));
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors() && !\Yii::$app->security->validatePassword($this->currentPassword, $this->password)) {
            $this->addError($attribute, \Yii::t('user', 'Entered password is incorrect'));
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'email' => \Yii::t('user', 'New e-mail'),
            'currentPassword' => \Yii::t('user', 'Current password'),
        ]);
    }

    public function changeEmail() {
        return $this->validate()
        && $this->save(false)
        && $this->sendNewConfirmationMail();
    }
}