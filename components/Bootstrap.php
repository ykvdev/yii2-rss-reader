<?php

namespace app\components;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;
use yii\helpers\Url;
use yii\web\Controller;

class Bootstrap implements BootstrapInterface
{
    /** @var Application */
    private $app;

    public function bootstrap($app) {
        $this->app = $app;

        $this->setCurrentLanguageOrRedirect();
        $this->fillControllerMap();
        $this->makePageTitle();
    }

    private function setCurrentLanguageOrRedirect() {
        Event::on(
            Application::className(),
            Application::EVENT_BEFORE_REQUEST,
            function($event) {
                list($route, $params) = $this->app->getUrlManager()->parseRequest($this->app->request);
                if($route
                && strlen($route) > 3
                && !isset($params['currentLanguage'])) {
                    $availableLanguages = $this->app->params['i18n']['available-languages'];
                    $defaultLanguage = $this->app->params['i18n']['default-language'];
                    $currentLanguage = $this->app->request->getPreferredLanguage($availableLanguages);
                    $currentLanguage = $currentLanguage ? array_search($currentLanguage, $availableLanguages) : $defaultLanguage;
                    $redirectUrl = Url::base() . '/' . $currentLanguage . '/' . $route;

                    $this->app->response->redirect($redirectUrl);
                    $this->app->response->send();
                    $this->app->end();
                }
            }
        );

        Event::on(
            Controller::className(),
            Controller::EVENT_BEFORE_ACTION,
            function($event) {
                $currentLanguage = $this->app->request->get('currentLanguage');
                $availableLanguages = $this->app->params['i18n']['available-languages'];
                $defaultLanguage = $this->app->params['i18n']['default-language'];

                if($currentLanguage && isset($availableLanguages[$currentLanguage])) {
                    $this->app->language = $currentLanguage;
                } else {
                    $currentLanguage = $this->app->request->getPreferredLanguage($availableLanguages);
                    $currentLanguage = $currentLanguage ? array_search($currentLanguage, $availableLanguages) : $defaultLanguage;

                    $moduleId = $this->app->controller->module->id;
                    $controllerId = $this->app->controller->id;
                    $actionId = $this->app->controller->action->id;
                    $this->app->response->redirect(array_merge(
                        $this->app->request->get(),
                        [
                            "/{$moduleId}/{$controllerId}/{$actionId}",
                            'currentLanguage' => $currentLanguage
                        ]
                    ));
                    $this->app->response->send();
                    $this->app->end();
                }
            }
        );
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