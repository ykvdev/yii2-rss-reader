<?php

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

?>
Hello <?= isset($this->params['name']) ? $this->params['name'] : '' ?>

<?= $content ?>

<?= Yii::$app->homeUrl ?>
