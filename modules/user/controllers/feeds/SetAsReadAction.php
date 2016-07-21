<?php

namespace app\modules\user\controllers\feeds;

use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\base\Action;

class SetAsReadAction extends Action
{
    public function run() {
        $feedId = \Yii::$app->request->get('feed_id');
        /** @var FeedModel $feed */
        $feed = FeedModel::findOne($feedId);
        if($feed && $feed->user == \Yii::$app->user->identity->id) {
            NewModel::updateAll([
                'read' => 1,
            ], [
                'feed' => $feedId,
                'read' => 0
            ]);

            \Yii::$app->cache->delete($this->getNewsCacheKey($feedId));
            \Yii::$app->cache->delete($this->getFeedsCacheKey());
        }

        return $this->controller->redirect(['/user/news/list', 'feed_id' => $feedId, 'page' => 1]);
    }

    private function getNewsCacheKey($feedId) {
        return 'news-' . $feedId;
    }

    private function getFeedsCacheKey() {
        return 'feeds-' . \Yii::$app->user->identity->id;
    }
}