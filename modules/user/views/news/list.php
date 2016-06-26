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

    <div class="panel panel-default news-list-container">
        <div class="panel-heading">
            <div>
                <div class="left-side"><h3 class="panel-title"><?= $currentFeed->title ?></h3></div>
                <div class="right-side">
                    <div class="btn-group">
                        <a href="<?= Url::toRoute(['/user/feeds/set-as-read', 'feed_id' => $currentFeed->id]) ?>"
                           class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Прочитано</a>
                        <a href="<?= Url::toRoute(['/user/feeds/unsubscribe', 'feed_id' => $currentFeed->id]) ?>"
                           class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Отписаться</a>
                    </div>
                </div>
                <br style="clear: both">
            </div>
        </div>
        <div class="panel-body">
            <?php foreach($news as $new): ?>
                <div class="new-item">
                    <h4><?= $new->title ?></h4>
                    <div <?= !$new->read ? 'style="font-weight:bold"' : '' ?>><?= $new->short_text ?></div>
                    <a href="<?= $new->url ?>" target="_blank" class="btn btn-default">Подробнее</a>
                    <hr>
                </div>
            <?php endforeach ?>
        </div>
        <div class="panel-footer">
            <div class="left-side">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages
                ]) ?>
            </div>
            <div class="right-side">
                <div class="btn-group">
                    <a href="<?= Url::toRoute(['/user/feeds/set-as-read', 'feed_id' => $currentFeed->id]) ?>"
                       class="btn btn-default"><span class="glyphicon glyphicon-ok"></span> Прочитано</a>
                    <a href="<?= Url::toRoute(['/user/feeds/unsubscribe', 'feed_id' => $currentFeed->id]) ?>"
                       class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Отписаться</a>
                </div>
            </div>
            <br style="clear: both">
        </div>
    </div>
</div>