<?php

/** @var $this \yii\web\View */
/** @var $signUpForm \app\modules\guest\models\forms\SignUpForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Регистрация';

?>
<div class="sign-up-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]]) ?>
    <?= $form->field($signUpForm, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($signUpForm, 'password')->passwordInput() ?>
    <?= $form->field($signUpForm, 'repassword')->passwordInput() ?>
    <?= $form->field($signUpForm, 'captcha')->widget(Captcha::className(), [
        'captchaAction' => \yii\helpers\Url::toRoute('/common/common/captcha'),
        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
        'template' => '{image} <a href="#" class="captcha-refresh-link" title="Получить другие цифры"
                        ><span class="glyphicon glyphicon-refresh"></span></a> {input}'
    ]) ?>
    <?= $form->field($signUpForm, 'acceptAgreement')->checkbox()->label('Принять условия ' . Html::a(
            'пользовательского сглашения',
            ['/common/common/page', 'view' => 'agreement'],
            ['target' => '_blank'])) ?>
    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>