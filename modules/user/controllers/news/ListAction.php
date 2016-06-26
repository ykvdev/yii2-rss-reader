<?php

namespace app\modules\user\controllers\news;

use app\modules\common\models\db\UserModel;
use yii\base\Action;
use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

class ListAction extends Action
{
    /** @var FeedModel */
    private $currentFeed;

    public function run() {
        list($news, $pages) = $this->getNewsList();
        return $this->controller->render('list', [
            'feeds' => $this->getFeedsList(),
            'currentFeed' => $this->getCurrentFeed(),
            'news' => $news,
            'pages' => $pages
        ]);
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
            $feed['icon_uri'] = FeedModel::getIconUri($feed['id']);
        }
    }

    private function getCurrentFeed() {
        if(!$this->currentFeed) {
            if ($feedId = \Yii::$app->request->get('feed_id')) {
                $this->currentFeed = FeedModel::findOne($feedId);
            } else {
                /** @var UserModel $userModel */
                $userModel = \Yii::$app->user->identity;
                $userFirstFeed = $userModel->getFeedModels(1);
                $this->currentFeed = $userFirstFeed ? $userFirstFeed[0] : null;
            }
        }

        return $this->currentFeed;
    }

    private function getNewsList() {
        $newsQuery = $this->getCurrentFeed()->getNewsQuery();
        $countQuery = clone $newsQuery;
        $pages = new Pagination(['totalCount' => $countQuery->count(), /*'pageSize' => 1,*/ 'pageSizeParam' => false]);
        $news = $newsQuery->offset($pages->offset)->limit($pages->limit)->all();
        foreach($news as &$new) {
            $new->short_text = strip_tags($new->short_text);
        }
        return [$news, $pages];
    }
}