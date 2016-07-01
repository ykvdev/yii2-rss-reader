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
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if(Yii::$app->user->isGuest):
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Регистрация', 'url' => ['/guest/guest/sign-up']],
                ['label' => 'Авторизация', 'url' => ['/guest/user/sign-in']],
                ['label' => 'Восстановить пароль', 'url' => ['/guest/user/reset-password-request', 'email' => '']],
            ],
        ]);
    else:
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'encodeLabels' => false,
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-inbox"></span> Новости',
                    'url' => ['/user/news/list', 'feed_id' => '', 'page' => 1]],
                ['label' => '<span class="glyphicon glyphicon-plus"></span> Подписаться',
                    'url' => ['/user/feeds/subscribe']],
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-user"></span> ' . Yii::$app->user->identity->email,
                    'items' => [
                        ['label' => 'Изменить e-mail', 'url' => ['/user/user/change-email']],
                        ['label' => 'Изменить пароль', 'url' => ['/user/user/change-password']],
                        ['label' => 'Выход', 'url' => ['/user/user/sign-out']],
                    ]
                ],
            ],
        ]);
    endif;
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
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>