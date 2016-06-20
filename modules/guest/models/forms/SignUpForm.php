<?php

namespace app\modules\guest\models\forms;

use app\modules\common\models\db\UserModel;
use yii\helpers\Url;

class SignUpForm extends UserModel
{
    const SCENARIO_SIGN_UP = 'sign-up';

    public $repeatPassword, $captcha, $acceptAgreement;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_SIGN_UP;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_SIGN_UP => ['email', 'password', 'repeatPassword', 'captcha', 'acceptAgreement']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'unique', 'targetAttribute' => 'email'],

            ['repeatPassword', 'required', 'message' => 'Повторите пароль'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password',
                'message' => 'Введенные пароли не совпадают'],

            ['captcha', 'filter', 'filter' => 'trim'],
            ['captcha', 'required', 'message' => 'Введите проверочные цифры'],
            ['captcha', 'captcha', 'captchaAction' => Url::toRoute('/common/common/captcha'),
                'message' => 'Проверочные цифры введены не верно'],

            ['acceptAgreement', 'boolean'],
            ['acceptAgreement', 'required', 'requiredValue' => true,
                'message' => 'Вы должны принять условия соглашения'],
        ]);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'repeatPassword' => 'Повторите пароль',
            'captcha' => 'Введите проверочные цифры',
        ]);
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function signUp() {
        if($this->validate()
        && $this->save(false)
        && $this->sendConfirmationMail()
        && $userRedirect = $this->signIn(false)) {
            return $userRedirect;
        } else {
            return false;
        }
    }
}