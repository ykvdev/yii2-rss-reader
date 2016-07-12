<?php

namespace app\modules\user\controllers\feeds;

use app\modules\user\models\forms\SubscribeFeedForm;
use yii\base\Action;
use yii\helpers\Html;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SubscribeAction extends Action
{
    public function run() {
        $model = new SubscribeFeedForm(['user' => \Yii::$app->user->identity->id]);
        if($model->load(\Yii::$app->request->post())) {
            $model->fillFormByUrl();
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;

                $resultValidation = [];
                foreach ($model->getErrors() as $attribute => $errors) {
                    $resultValidation[Html::getInputId($model, $attribute)] = $errors;
                }

                return array_merge($resultValidation, ActiveForm::validate($model));
            } elseif($userRedirect = $model->subscribe()) {
                \Yii::$app->session->setFlash('info', \Yii::t('user', 'Feed has been added to your subscriptions'));
                return $userRedirect;
            }
        }

        return $this->controller->render('subscribe', compact('model'));
    }
}