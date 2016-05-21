<?php

namespace app\components;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
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
}