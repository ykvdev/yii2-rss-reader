<?php

namespace app\modules\user\controllers\news;

use app\modules\common\models\db\UserModel;
use yii\base\Action;
use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\StringHelper;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class ListAction extends Action
{
    /** @var FeedModel */
    private $currentFeed;

    public function run() {
        if(!$this->getCurrentFeed()) {
            \Yii::$app->session->addFlash('info', \Yii::t('user', 'You has no subscriptions'));
            return $this->controller->redirect(['/user/feeds/subscribe']);
        }

        $this->checkForNews();
        list($news, $pages) = $this->getNewsList();
        return $this->controller->render('list', [
            'feeds' => $this->getFeedsList(),
            'currentFeed' => $this->getCurrentFeed(),
            'news' => $news,
            'pages' => $pages
        ]);
    }

    private function checkForNews() {
        try {
            $response = (new Client())->createRequest()->setUrl($this->getCurrentFeed()->url)->send();
            if(!$response->isOk) {
                throw new \Exception;
            }

            $rss = simplexml_load_string($response->getContent());
            $newItemsCount = 0;
            foreach ($rss->channel->item as $item) {
                if(!NewModel::findOne(['feed' => $this->getCurrentFeed()->id, 'url' => (string)$item->link])) {
                    $new = new NewModel();
                    $new->feed = $this->getCurrentFeed()->id;
                    $new->published_at = date_create_from_format(\DateTime::RSS, (string)$item->pubDate)->format('Y-m-d H:i:s');
                    $new->title = (string)$item->title;
                    if(isset($item->description)) {
                        $new->short_text = StringHelper::truncate(strip_tags((string)$item->description), 250);
                    }
                    $new->url = (string)$item->link;
                    if($new->save()) {
                        $newItemsCount++;
                    }
                }
            }

            if($newItemsCount > 0) {
                \Yii::$app->session->addFlash('info', \Yii::t('user', 'Get news: ') . $newItemsCount);
                $this->clearOldNewsIfNeed();
                \Yii::$app->cache->delete($this->getNewsCacheKey());
                \Yii::$app->cache->delete($this->getFeedsCacheKey());
            }
        } catch(Exception $e) {
            \Yii::$app->session->addFlash('danger', \Yii::t('user', 'Get news error'));
        }
    }

    private function clearOldNewsIfNeed() {
        $newsCount = NewModel::find()->where([
            'feed' => $this->getCurrentFeed()->id
        ])->count();
        if($newsCount > \Yii::$app->params['news']['max-count']) {
            \Yii::$app->db->createCommand(sprintf(
                'DELETE FROM %s ORDER BY published_at LIMIT %d',
                NewModel::tableName(),
                $newsCount - \Yii::$app->params['news']['max-count']
            ))->execute();
        }
    }

    private function getNewsList() {
        if($news = \Yii::$app->cache->get($this->getNewsCacheKey())) {
            return $news;
        } else {
            $newsQuery = $this->getCurrentFeed()->getNewsQuery();
            $countQuery = clone $newsQuery;
            $pages = new Pagination(['totalCount' => $countQuery->count(), /*'pageSize' => 1,*/
                'pageSizeParam' => false]);
            $news = $newsQuery->orderBy('published_at DESC')->offset($pages->offset)->limit($pages->limit)->all();
            foreach ($news as &$new) {
                $new->short_text = strip_tags($new->short_text);
            }

            \Yii::$app->cache->set($this->getNewsCacheKey(), [$news, $pages]);

            return [$news, $pages];
        }
    }

    private function getFeedsList() {
        if(!$feeds = \Yii::$app->cache->get($this->getFeedsCacheKey())) {
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

            \Yii::$app->cache->set($this->getFeedsCacheKey(), $feeds);
        }

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

    private function getNewsCacheKey() {
        return 'news-' . $this->getCurrentFeed()->id;
    }

    private function getFeedsCacheKey() {
        return 'feeds-' . \Yii::$app->user->identity->id;
    }
}