<?php

namespace app\modules\user\controllers\feeds;

use app\modules\user\models\forms\SubscribeFeedForm;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SubscribeAction extends Action
{
    public function run() {
        $model = new SubscribeFeedForm(['user' => \Yii::$app->user->identity->id]);
        if($model->load(\Yii::$app->request->post())) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif($userRedirect = $model->subscribe()) {
                \Yii::$app->session->setFlash('info', 'Канал добавлен в ваши подписки');
                return $userRedirect;
            }
        }

        return $this->controller->render('subscribe', compact('model'));
    }
}