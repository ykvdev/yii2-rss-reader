<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\guest\models\forms\ResetPasswordForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('guest', 'Change password');

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin(['fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]]) ?>
    <?= $form->field($model, 'newPassword')->passwordInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'repeatPassword')->passwordInput() ?>
    <?= Html::submitButton(Yii::t('guest', 'Change password'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>