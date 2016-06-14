<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        Event::on(
            \yii\web\View::className(),
            \yii\web\View::EVENT_AFTER_RENDER,
            function($event) use ($app) {
                $app->view->title = implode(' - ', [
                    $app->view->title,
                    \Yii::$app->name
                ]);
            }
        );
    }
}