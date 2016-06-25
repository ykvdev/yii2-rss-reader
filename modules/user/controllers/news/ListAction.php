<?php

namespace app\modules\user\controllers\news;

use app\modules\common\models\db\UserModel;
use yii\base\Action;
use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\db\Expression;
use yii\db\Query;

class ListAction extends Action
{
    /** @var FeedModel */
    private $currentFeed;

    public function run() {
        $this->initFeedId();

        return $this->controller->render('list', [
            'currentFeed' => $this->currentFeed,
            'feeds' => $this->getFeedsList()
        ]);
    }

    private function initFeedId() {
        if($feedId = \Yii::$app->request->get('feed_id')) {
            $this->currentFeed = FeedModel::findOne($feedId);
        } else {
            /** @var UserModel $userModel */
            $userModel = \Yii::$app->user->identity;
            $userFirstFeed = $userModel->getFeedModels(1);
            $this->currentFeed = $userFirstFeed ? $userFirstFeed[0] : null;
        }
    }

    private function getNewsList() {

    }

    private function getFeedsList() {
        $noReadCountQuery = (new Query())
            ->select('COUNT(id)')
            ->from(NewModel::tableName())
            ->where(new Expression('feed = feeds.id'))
            ->andWhere(['read' => 0]);
        $feeds = (new Query())
            ->select(['*', 'no_read_count' => $noReadCountQuery])
            ->from(FeedModel::tableName())
            ->where(['user' => \Yii::$app->user->identity->id])
            ->all();

        $this->injectFeedIcons($feeds);

        return $feeds;
    }

    private function injectFeedIcons(array &$feedsList) {
        foreach($feedsList as &$feed) {
            $iconPathPattern = \Yii::getAlias("@webroot/uploads/feed_icons/{$feed['id']}.*");
            $findIcons = glob($iconPathPattern);
            if(isset($findIcons[0])) {
                $feed['icon_uri'] = \Yii::getAlias('@web/uploads/feed_icons/' . basename($findIcons[0]));
            }
        }
    }
}