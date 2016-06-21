<?php

namespace app\modules\user\controllers;

use app\modules\common\models\db\FeedModel;
use app\modules\common\models\db\NewModel;
use yii\db\Expression;
use yii\db\Query;
use yii\web\Controller;

class NewsController extends Controller
{
    public function actionList() {
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

        return $this->render('list', [
            'feeds' => $feeds
        ]);
    }
}