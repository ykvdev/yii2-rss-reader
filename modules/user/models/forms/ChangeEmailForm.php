<?php

namespace app\modules\user\models\forms;

use app\modules\common\models\db\UserModel;

class ChangeEmailForm extends UserModel
{
    const SCENARIO_CHANGE_EMAIL = 'change-email';

    public $nativePassword;

    protected $skipFieldsForPopulate = ['email'];

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CHANGE_EMAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CHANGE_EMAIL => ['email', 'nativePassword']
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['email', 'unique', 'targetAttribute' => 'email', 'filter' => ['!=', 'id', \Yii::$app->user->identity->id]],
            ['email', 'validateEmailEquivalent'],

            ['nativePassword', 'required'],
            ['nativePassword', 'validatePassword'],
        ]);
    }

    public function validateEmailEquivalent($attribute, $params) {
        if (!$this->hasErrors() && $this->email === \Yii::$app->user->identity->email) {
            $this->addError($attribute, 'Введенный e-mail эквивалентен текущему');
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors() && !\Yii::$app->security->validatePassword($this->nativePassword, $this->password)) {
            $this->addError($attribute, 'Введенный пароль не верный');
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'email' => 'Новый e-mail',
            'nativePassword' => 'Текущий пароль',
        ]);
    }

    public function changeEmail() {
        return $this->validate()
        && $this->save();
    }
}