<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\user\models\forms\SubscribeFeedForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('user', 'Subscribe');

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'subscribe-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => ['inputOptions' => ['autocomplete' => 'off']]
    ]) ?>
    <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>
    <?= Html::submitButton(Yii::t('user', 'Subscribe'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>