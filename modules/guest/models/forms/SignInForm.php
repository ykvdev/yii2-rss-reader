<?php

namespace app\modules\guest\models\forms;

use Yii;
use app\modules\common\models\db\UserModel;
use yii\helpers\Html;
use yii\web\Response;

class SignInForm extends UserModel
{
    const SCENARIO_SIGN_IN = 'sign-in';

    public $nativePassword, $rememberMe = true;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_SIGN_IN;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_SIGN_IN => ['email', 'nativePassword', 'rememberMe']
        ]);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailConfirmation'],

            ['nativePassword', 'required'],
            ['nativePassword', 'validatePassword'],

            ['rememberMe', 'boolean'],
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

    public function validateEmailConfirmation($attribute, $params) {
        if(!$this->hasErrors()) {
            if($this->id && !$this->confirmed) {
                $this->addError($attribute, sprintf(
                    'Ваш e-mail не подтвержден.
                    Вы должны перейти по ссылке из письма для подтверждения e-mail адреса.
                    Если вы не получали это письмо, вы можете %s.',
                    Html::a('запросить его повторно', ['/guest/user/resend-confirmation-mail', 'email' => $this->email])
                ));
            }
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->id || !Yii::$app->security->validatePassword($this->nativePassword, $this->password)) {
                $this->addError($attribute, 'Не корректное имя пользователя или пароль');
            }
        }
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'nativePassword' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ]);
    }

    /**
     * @param bool|false $rememberMe
     * @param bool|true $withRedirect
     * @return Response|bool
     */
    public function signIn($rememberMe = false, $withRedirect = true) {
        if (!$this->validate()) {
            return false;
        }

        return parent::signIn($this->rememberMe);
    }
}
