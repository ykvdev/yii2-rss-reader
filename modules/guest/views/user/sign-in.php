<?php

/* @var $this yii\web\View */
/* @var $model app\modules\guest\models\forms\SignInForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('guest', 'Sign in');

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'inputOptions' => ['autocomplete' => 'off'],
            'errorOptions' => ['encode' => false]
        ],
    ]); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'nativePassword')->passwordInput() ?>
    <?php if($model->isNeedToShowCaptcha()): ?>
        <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
            'captchaAction' => \yii\helpers\Url::toRoute('/common/common/captcha'),
            'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
            'template' => '{image} <a href="#" class="captcha-refresh-link" title="' . Yii::t('guest', 'Refresh digits')
                        . '"><span class="glyphicon glyphicon-refresh"></span></a> {input}'
        ]) ?>
    <?php endif ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    <?= Html::submitButton(Yii::t('guest', 'Sign in'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
