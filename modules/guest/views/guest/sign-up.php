<?php

/** @var $this \yii\web\View */
/** @var $signUpForm \app\modules\guest\models\forms\SignUpForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Регистрация';

?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($signUpForm, 'email')->textInput(['autofocus' => true]) ?>
<?= $form->field($signUpForm, 'password')->passwordInput() ?>
<?= $form->field($signUpForm, 'repassword')->passwordInput() ?>
<?= $form->field($signUpForm, 'captcha')->widget(Captcha::className()/*, [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]*/) ?>
<?= $form->field($signUpForm, 'acceptAgreement')->checkbox(/*[
    'template' => '{input} {label}'
]*/) ?>
<?= Html::submitButton('Регистрация') ?>
<?php ActiveForm::end() ?>
