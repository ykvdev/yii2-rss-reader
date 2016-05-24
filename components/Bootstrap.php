<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        Event::on(
            \yii\web\Controller::className(),
            \yii\web\Controller::EVENT_BEFORE_ACTION,
            [$this, 'registerPageAssets']
        );

        Event::on(
            \yii\web\View::className(),
            \yii\web\View::EVENT_AFTER_RENDER,
            function($event) use ($app) {
                $app->view->title = implode(' - ', [
                    $app->view->title,
                    'RSS Reader'
                ]);
            }
        );
    }

    public function registerPageAssets($event) {
        $assetFileName = str_replace('/', '-', \Yii::$app->controller->route);

        $cssFilePath = '/css/pages/' . $assetFileName . '.css';
        if(file_exists(\Yii::getAlias('@webroot' . $cssFilePath))) {
            \Yii::$app->view->registerCssFile('@web' . $cssFilePath);
        }

        $jsFilePath = '/js/pages/' . $assetFileName . '.js';
        if(file_exists(\Yii::getAlias('@webroot' . $jsFilePath))) {
            \Yii::$app->view->registerJsFile('@web' . $jsFilePath);
        }
    }
}