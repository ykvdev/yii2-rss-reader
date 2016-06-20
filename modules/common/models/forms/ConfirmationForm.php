<?php

namespace app\modules\common\models\forms;

use app\modules\common\models\db\UserSecurityModel;

class ConfirmationForm extends UserSecurityModel
{
    const SCENARIO_CONFIRMATION_EMAIL = 'confirmation-email';

    public function init() {
        parent::init();
        $this->scenario = self::SCENARIO_CONFIRMATION_EMAIL;
    }

    public function scenarios() {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CONFIRMATION_EMAIL => ['hash_id', 'confirmation_hash']
        ]);
    }

    public function rules() {
        return array_merge(parent::rules(), [
            ['confirmation_hash', 'required'],
            ['confirmation_hash', 'validateConfirmationHash'],
        ]);
    }

    public function validateConfirmationHash($attribute, $params) {
        if(!$this->hasErrors() && !$this->user) {
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
        if(!$this->confirmed) {
            $this->confirmation_hash = null;
            $this->confirmed = 1;
            return $this->save(false);
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