<?php

namespace app\modules\common\models\forms;

use app\modules\common\models\db\UserModel;

class ConfirmationForm extends UserModel
{
    const SCENARIO_CONFIRMATION_EMAIL = 'confirmation-email';

    /** @var string */
    public $hash;

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CONFIRMATION_EMAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CONFIRMATION_EMAIL => ['email', 'hash']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['email', 'validateEmailExisting'],

            ['hash', 'required'],
            ['hash', 'validateHash'],
        ]);
    }

    public function validateEmailExisting($attribute, $params) {
        if(!$this->hasErrors()) {
            if(!$this->id) {
                $this->addError($attribute, 'Такой e-mail адрес не найден');
            }
        }
    }

    public function validateHash($attribute, $params) {
        if(!$this->hasErrors() && $this->hash !== $this->getUserSecurityModel()->confirmation_hash) {
            $this->addError($attribute, 'Ссылка подтверждения e-mail адреса не верная');
        }
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function confirm() {
        if($this->validate()
        && $this->setConfirmed()
        && $userRedirect = $this->getRedirection()) {
            return $userRedirect;
        } else {
            return false;
        }
    }

    private function setConfirmed() {
        $securityModel = $this->getUserSecurityModel();
        if(!$securityModel->confirmed) {
            $securityModel->confirmation_hash = null;
            $securityModel->confirmed = 1;
            return $securityModel->save();
        } else {
            return true;
        }
    }

    private function getRedirection() {
        if(\Yii::$app->user->isGuest) {
            return $this->signIn();
        } else {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->getReturnUrl());
        }
    }
}