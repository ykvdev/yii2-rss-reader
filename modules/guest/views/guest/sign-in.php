<?php

/* @var $this yii\web\View */
/* @var $signInForm app\modules\guest\models\forms\SignInForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';

?>
<div class="sign-in-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]]); ?>
    <?= $form->field($signInForm, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($signInForm, 'password')->passwordInput() ?>
    <?= $form->field($signInForm, 'rememberMe')->checkbox() ?>
    <?= Html::submitButton('Авторизация', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
