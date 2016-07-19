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

            ['repeatPassword', 'required', 'message' => \Yii::t('guest', 'Repeat password')],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password',
                'message' => \Yii::t('guest', 'Filled passwords is not equal')],

            ['captcha', 'filter', 'filter' => 'trim'],
            ['captcha', 'required', 'message' => \Yii::t('guest', 'Enter controlling digits')],
            ['captcha', 'captcha', 'captchaAction' => Url::toRoute('/common/common/captcha'),
                'message' => \Yii::t('guest', 'Controlling digits is not correct')],

            ['acceptAgreement', 'boolean'],
            ['acceptAgreement', 'required', 'requiredValue' => true,
                'message' => \Yii::t('guest', 'You are need to accept agreement')],
        ]);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'repeatPassword' => \Yii::t('guest', 'Repeat password'),
            'captcha' => \Yii::t('guest', 'Enter controlling digits'),
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