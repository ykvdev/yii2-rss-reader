<?php

/** @var $this \yii\web\View */
/** @var $model \app\modules\guest\models\forms\ResetPasswordRequestForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Восстановление пароля';

?>
<div class="form-page">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'reset-password-request-form',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'inputOptions' => ['autocomplete' => 'off'],
            'errorOptions' => ['encode' => false]
        ]
    ]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
        'captchaAction' => Url::toRoute('/common/common/captcha'),
        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
        'template' => '{image} <a href="#" class="captcha-refresh-link" title="Получить другие цифры"
                        ><span class="glyphicon glyphicon-refresh"></span></a> {input}'
    ]) ?>
    <?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>
