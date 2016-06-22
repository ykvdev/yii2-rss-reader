<?php

namespace app\modules\user\controllers\news;

use yii\base\Action;
use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\db\Expression;
use yii\db\Query;

class ListAction extends Action
{
    public function run() {
        return $this->controller->render('list', [
            'feeds' => $this->getFeedsList()
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

        return $feeds;
    }
}