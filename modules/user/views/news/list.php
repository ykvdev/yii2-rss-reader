<?php

use \yii\helpers\Html,
    yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $feeds array */
/** @var $currentFeed \app\modules\common\models\db\FeedModel */
/** @var $news \app\modules\common\models\db\NewModel[] */
/** @var $pages \yii\data\Pagination */

$this->title = 'Список новостей';

?>
<div class="news-list-page">
    <ul class="nav nav-pills nav-stacked">
        <?php foreach($feeds as $feed): ?>
            <li <?= $feed['id'] == $currentFeed->id ? 'class="active"' : '' ?>
            ><a href="<?= Url::toRoute(['/user/news/list', 'feed_id' => $feed['id'], 'page' => 1]) ?>">
                <?php if(isset($feed['icon_uri'])): ?>
                    <img src="<?= $feed['icon_uri'] ?>" width="16" height="16">
                <?php endif ?>

                <?= $feed['title'] ?>

                <?php if($feed['no_read_count']): ?>
                    <span class="badge"><?= $feed['no_read_count'] ?></span>
                <?php endif ?>
            </a></li>
        <?php endforeach ?>
    </ul>
    <div class="news-list-container">
        <?php foreach($news as $new): ?>
            <div class="new-item">
                <h4><?= $new->title ?></h4>
                <div <?= !$new->read ? 'style="font-weight:bold"' : '' ?>><?= $new->short_text ?></div>
                <a href="<?= $new->url ?>" target="_blank" class="btn btn-default">Подробнее</a>
                <hr>
            </div>
        <?php endforeach ?>

        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages
        ]) ?>
    </div>
</div>