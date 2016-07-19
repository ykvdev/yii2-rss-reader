<?php

namespace app\modules\guest\models\forms;

use Yii;
use app\modules\common\models\db\UserModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

class SignInForm extends UserModel
{
    const SCENARIO_SIGN_IN = 'sign-in';

    public $nativePassword, $captcha, $rememberMe = true;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_SIGN_IN;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_SIGN_IN => array_merge(
                ['email', 'nativePassword', 'rememberMe'],
                $this->isNeedToShowCaptcha() ? ['captcha'] : []
            )
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

            ['captcha', 'filter', 'filter' => 'trim'],
            ['captcha', 'required', 'message' => Yii::t('guest', 'Enter controlling digits')],
            ['captcha', 'captcha', 'captchaAction' => Url::toRoute('/common/common/captcha'),
                'message' => Yii::t('guest', 'Controlling digits is not correct')],
        ]);
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->id || !Yii::$app->security->validatePassword($this->nativePassword, $this->password)) {
                $this->incrementFailAuthCounterIfNeed();
                $this->addError($attribute,  Yii::t('guest',
                    'Incorrect e-mail or password. If you forgot password you can {0}',
                    Html::a(Yii::t('guest', 'reset it'), ['/guest/user/reset-password-request', 'email' => $this->email])
                ));
            }
        }
    }

    private function incrementFailAuthCounterIfNeed() {
        if($this->id && !$this->isNeedToShowCaptcha()) {
            $securityModel = $this->getUserSecurityModel();
            $securityModel->last_fail_auth_count++;
            $securityModel->save();
        }
    }

    public function isNeedToShowCaptcha() {
        $securityModel = $this->getUserSecurityModel();
        return $securityModel && $securityModel->last_fail_auth_count
        >= Yii::$app->params['user']['sign-in']['max-fail-auth-count'];
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'nativePassword' => Yii::t('guest', 'Password'),
            'rememberMe' => Yii::t('guest', 'Remember me'),
            'captcha' => Yii::t('guest', 'Enter controlling digits'),
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
        && $this->resetFailAuthCounter()
        && $userRedirect = parent::signIn(true, $this->rememberMe)) {
            return $userRedirect;
        } else {
            return false;
        }
    }

    private function resetFailAuthCounter() {
        $securityModel = $this->getUserSecurityModel();
        $securityModel->last_fail_auth_count = 0;
        return $securityModel->save();
    }
}