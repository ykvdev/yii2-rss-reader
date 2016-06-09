<?php

/* @var $this yii\web\View */
/* @var $model app\modules\guest\models\forms\SignInForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';

?>
<div class="sign-in-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'inputOptions' => ['autocomplete' => 'off'],
            'errorOptions' => ['encode' => false]
        ],
    ]); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'nativePassword')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    <?= Html::submitButton('Авторизация', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
