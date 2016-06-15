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

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->id || !Yii::$app->security->validatePassword($this->nativePassword, $this->password)) {
                $this->addError($attribute, sprintf(
                    'Не корректное имя пользователя или пароль.
                    Если вы забыли пароль, вы можете %s',
                    Html::a('восстановить его', ['/guest/user/reset-password-request', 'email' => $this->email])
                ));
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
     * @param bool|true $validateConfirmation
     * @return Response|bool
     */
    public function signIn($rememberMe = false, $withRedirect = true, $validateConfirmation = false) {
        if ($this->validate()
        && $userRedirect = parent::signIn(true, $this->rememberMe)) {
            return $userRedirect;
        } else {
            return false;
        }
    }
}
