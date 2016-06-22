<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    /** @var Application */
    private $app;

    public function bootstrap($app) {
        $this->app = $app;

        $this->fillControllerMap();
        $this->makePageTitle();
    }

    /**
     * Fill $app->controllerMap property for auto run action classes
     */
    private function fillControllerMap() {
        $modulesPath = \Yii::getAlias("@app/modules");
        $modulesDir = new \DirectoryIterator($modulesPath);
        foreach($modulesDir as $moduleDir) {
            if($moduleDir->isDir() && !$moduleDir->isDot()) {
                $moduleId = $moduleDir->getBasename();
                $controllersPath = $modulesPath . '/' . $moduleId . '/controllers';
                $controllersDir = new \DirectoryIterator($controllersPath);
                foreach($controllersDir as $controllerDir) {
                    if ($controllerDir->isDir() && !$controllerDir->isDot()) {
                        $controllerId = $controllerDir->getBasename();
                        $pathOfDefinedController = $controllersPath . '/' . ucfirst($controllerId) . 'Controller';
                        $namespaceOfDefinedController = "app\\modules\\{$moduleId}\\controllers\\"
                            . ucfirst($controllerId) . 'Controller';

                        $modulesConfig = $this->app->modules;
                        $modulesConfig[$moduleId]['controllerMap'][$controllerId] = file_exists($pathOfDefinedController)
                            ? $namespaceOfDefinedController
                            : Controller::className();
                        $this->app->modules = $modulesConfig;
                    }
                }
            }
        }
    }

    private function makePageTitle() {
        Event::on(
            \yii\web\View::className(),
            \yii\web\View::EVENT_AFTER_RENDER,
            function($event) {
                $this->app->view->title = implode(' - ', [
                    $this->app->view->title,
                    \Yii::$app->name
                ]);
            }
        );
    }
}