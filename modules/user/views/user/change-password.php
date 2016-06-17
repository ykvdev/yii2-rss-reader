<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/** @var $this \yii\web\View */
/** @var $model \app\modules\user\models\forms\ChangePasswordForm */

$this->title = 'Изменить пароль';

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'change-password-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]
    ]) ?>
    <?= $form->field($model, 'currentPassword')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'newPassword')->passwordInput() ?>
    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>
    <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>