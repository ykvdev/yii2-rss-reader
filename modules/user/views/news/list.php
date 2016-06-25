<?php

use \yii\helpers\Html,
    yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $currentFeed \app\modules\common\models\db\FeedModel */
/** @var $feeds array */

$this->title = 'Список новостей';

?>
<div class="news-list-page">
    <ul class="nav nav-pills nav-stacked">
        <?php foreach($feeds as $feed): ?>
            <li <?= $feed['id'] == $currentFeed->id ? 'class="active"' : '' ?>
            ><a href="<?= Url::toRoute(['/user/news/list', 'feed_id' => $feed['id']]) ?>">
                <?php if(isset($feed['icon_uri'])): ?>
                    <img src="<?= $feed['icon_uri'] ?>" width="16" height="16">
                <?php endif ?>

                <?= $feed['title'] ?>

                <?php if($feed['no_read_count']): ?>
                    <span class="badge"><?= $feed['no_read_count'] ?></span>
                <?php endif ?>
            </a></li>
        <?php endforeach ?>

<!--        <li role="presentation" class="active"><a href="#">Home <span class="badge">4</span></a></li>-->
<!--        <li role="presentation"><a href="#">Profile</a></li>-->
<!--        <li role="presentation"><a href="#">Messages</a></li>-->
    </ul>
    <div class="news-list-container">
        News list...
    </div>
</div>