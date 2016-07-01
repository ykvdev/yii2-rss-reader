<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\user\models\forms\SubscribeFeedForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Подписаться';

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'subscribe-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]
    ]) ?>
    <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>
    <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>