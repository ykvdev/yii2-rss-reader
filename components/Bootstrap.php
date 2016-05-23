<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        $this->initActionClasses($app);

        Event::on(
            \yii\web\Controller::className(),
            \yii\web\Controller::EVENT_BEFORE_ACTION,
            [$this, 'registerPageAssets']
        );
    }

    public function initActionClasses(Application $app) {
        // Fill $app->controllerMap property for auto run action classes
        $controllersPath = \Yii::getAlias('@app/controllers');
        $dir = new \DirectoryIterator($controllersPath);
        foreach($dir as $item) {
            if($item->isDir() && !$item->isDot()) {
                $controllerId = $item->getBasename();
                $pathOfDefinedController = $controllersPath . '/' . ucfirst($controllerId) . 'Controller';
                $namespaceOfDefinedController = 'app\controllers\\' . ucfirst($controllerId) . 'Controller';
                $app->controllerMap[$controllerId] = file_exists($pathOfDefinedController)
                    ? $namespaceOfDefinedController
                    : Controller::className();
            }
        }
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