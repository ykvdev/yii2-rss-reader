<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\guest\models\forms\SignUpForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('guest', 'Sign up');

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
        'fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]
    ]) ?>
    <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>
    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
        'captchaAction' => \yii\helpers\Url::toRoute('/common/common/captcha'),
        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
        'template' => '{image} <a href="#" class="captcha-refresh-link" title="' . Yii::t('guest', 'Refresh digits')
                    . '"><span class="glyphicon glyphicon-refresh"></span></a> {input}'
    ]) ?>
    <?= $form->field($model, 'acceptAgreement')->checkbox()->label(Yii::t('guest', 'Accept conditions ') . Html::a(
            Yii::t('guest', 'of user agreement'),
            ['/common/common/page', 'view' => 'agreement'],
            ['target' => '_blank'])) ?>
    <?= Html::submitButton(Yii::t('guest', 'Sign up'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>