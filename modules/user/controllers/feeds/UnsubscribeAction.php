<?php

namespace app\modules\user\controllers\feeds;

use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\base\Action;

class UnsubscribeAction extends Action
{
    public function run() {
        $feedId = \Yii::$app->request->get('feed_id');
        /** @var FeedModel $feed */
        $feed = FeedModel::findOne($feedId);
        if($feed && $feed->user == \Yii::$app->user->identity->id) {
            NewModel::deleteAll([
                'feed' => $feedId
            ]);
            $feed->delete();
            unlink(FeedModel::getIconPath($feed->id));
        }

        return $this->controller->redirect(['/user/news/list', 'feed_id' => '', 'page' => 1]);
    }
}