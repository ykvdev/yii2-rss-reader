<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'RSS Reader',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => Yii::$app->user->isGuest ? [
            ['label' => 'Регистрация', 'url' => ['/guest/guest/sign-up']],
            ['label' => 'Авторизация', 'url' => ['/guest/user/sign-in']],
            ['label' => 'Восстановить пароль', 'url' => ['/guest/guest/re-password']],
        ] : [
            // user space menu items
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php foreach(Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <div class="alert alert-<?= $type ?>" role="alert"><?= $message ?></div>
        <?php endforeach ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; RSS Reader <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>