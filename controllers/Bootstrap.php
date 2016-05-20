<?php

namespace app\controllers;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app) {
        // Fill $app->controllerMap property for auto run action classes
        $dir = new \DirectoryIterator(__DIR__);
        foreach($dir as $item) {
            if($item->isDir() && !$item->isDot()) {
                $controllerId = $item->getBasename();
                $pathOfDefinedController = __DIR__ . DIRECTORY_SEPARATOR . ucfirst($controllerId) . 'Controller';
                $namespaceOfDefinedController = __NAMESPACE__ . '\\' . ucfirst($controllerId) . 'Controller';
                $app->controllerMap[$controllerId] = file_exists($pathOfDefinedController)
                    ? $namespaceOfDefinedController
                    : BaseController::className();
            }
        }
    }
}