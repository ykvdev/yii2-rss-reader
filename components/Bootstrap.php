<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;
use yii\web\Controller;

class Bootstrap implements BootstrapInterface
{
    /** @var Application */
    private $application;

    public function bootstrap($application) {
        $this->application = $application;

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

                        $modulesConfig = $this->application->modules;
                        $modulesConfig[$moduleId]['controllerMap'][$controllerId] = file_exists($pathOfDefinedController)
                            ? $namespaceOfDefinedController
                            : Controller::className();
                        $this->application->modules = $modulesConfig;
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
                $this->application->view->title = implode(' - ', [
                    $this->application->view->title,
                    \Yii::$app->name
                ]);
            }
        );
    }
}