<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\user\models\forms\ChangeEmailForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('user', 'Change e-mail');

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'change-email-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]
    ]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'currentPassword')->passwordInput() ?>
    <?= Html::submitButton(Yii::t('user', 'Change'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>
