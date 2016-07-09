<?php

namespace app\components\bootstrap;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;
use yii\helpers\Url;
use yii\web\Controller;

class I18n implements BootstrapInterface
{
    /** @var Application */
    private $application;

    /** @var array */
    private $availableLanguages;

    /** @var string */
    private $defaultLanguage;

    public function bootstrap($application) {
        $this->application = $application;
        $this->availableLanguages = $this->application->params['i18n']['available-languages'];
        $this->defaultLanguage = $this->application->params['i18n']['default-language'];

        $this->addLanguageToUrlIfNeed();
        $this->setCurrentLanguageOrRedirect();
    }

    private function addLanguageToUrlIfNeed()
    {
        Event::on(
            Application::className(),
            Application::EVENT_BEFORE_REQUEST,
            function ($event) {
                list($route, $params) = $this->application->getUrlManager()->parseRequest($this->application->request);
                if ($route
                    && strlen($route) > 3
                    && !isset($params['currentLanguage'])
                ) {
                    $redirectUrl = Url::base() . '/' . $this->getPreferredLanguage() . '/' . $route;
                    $this->application->response->redirect($redirectUrl);
                    $this->application->response->send();
                    $this->application->end();
                }
            }
        );
    }

    private function setCurrentLanguageOrRedirect() {
        Event::on(
            Controller::className(),
            Controller::EVENT_BEFORE_ACTION,
            function($event) {
                $currentLanguage = $this->application->request->get('currentLanguage');
                if($currentLanguage && isset($this->availableLanguages[$currentLanguage])) {
                    $this->application->language = $currentLanguage;
                } else {
                    $moduleId = $this->application->controller->module->id;
                    $controllerId = $this->application->controller->id;
                    $actionId = $this->application->controller->action->id;
                    $this->application->response->redirect(array_merge(
                        $this->application->request->get(),
                        [
                            "/{$moduleId}/{$controllerId}/{$actionId}",
                            'currentLanguage' => $this->getPreferredLanguage()
                        ]
                    ));
                    $this->application->response->send();
                    $this->application->end();
                }
            }
        );
    }

    private function getPreferredLanguage() {
        $preferredLanguage = $this->application->request->getPreferredLanguage($this->availableLanguages);
        $preferredLanguage = $preferredLanguage ? array_search($preferredLanguage, $this->availableLanguages) : $this->defaultLanguage;
        return $preferredLanguage;
    }
}