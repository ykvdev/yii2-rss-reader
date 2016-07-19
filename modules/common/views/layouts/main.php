<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use app\components\SelectLanguageWidget;

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
                ['label' => Yii::t('common', 'Sign up'), 'url' => ['/guest/guest/sign-up']],
                ['label' => Yii::t('common', 'Sign in'), 'url' => ['/guest/user/sign-in']],
                ['label' => Yii::t('common', 'Reset password'), 'url' => ['/guest/user/reset-password-request', 'email' => '']],
            ],
        ]);
    else:
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'encodeLabels' => false,
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-inbox"></span> ' . Yii::t('common', 'News'),
                    'url' => ['/user/news/list', 'feed_id' => '', 'page' => 1]],
                ['label' => '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', 'Subscribe'),
                    'url' => ['/user/feeds/subscribe']],
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-user"></span> ' . Yii::$app->user->identity->email,
                    'items' => [
                        ['label' => Yii::t('common', 'Change e-mail'), 'url' => ['/user/user/change-email']],
                        ['label' => Yii::t('common', 'Change password'), 'url' => ['/user/user/change-password']],
                        ['label' => Yii::t('common', 'Sign out'), 'url' => ['/user/user/sign-out']],
                    ]
                ],
            ],
        ]);
    endif;
    NavBar::end();
    ?>

    <div class="container">
        <?php foreach(Yii::$app->session->getAllFlashes() as $type => $messages): ?>
            <?php foreach($messages as $message): ?>
                <div class="alert alert-<?= $type ?>" role="alert"><?= $message ?></div>
            <?php endforeach ?>
        <?php endforeach ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            &copy; <?= Yii::$app->name ?> <?= date('Y') ?> | <?= SelectLanguageWidget::widget() ?>
        </p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>