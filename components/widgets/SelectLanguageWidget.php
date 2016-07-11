<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\bootstrap\Html;

class SelectLanguageWidget extends Widget
{
    public function run() {
        $moduleId = \Yii::$app->controller->module->id;
        $controllerId = \Yii::$app->controller->id;
        $actionId = \Yii::$app->controller->action->id;
        if(\Yii::$app->language == 'ru-RU') {
            return Html::a('Go to English', ["/$moduleId/$controllerId/$actionId", 'currentLanguage' => 'en']);
        } else {
            return Html::a('Перейти на русский', ["/$moduleId/$controllerId/$actionId", 'currentLanguage' => 'ru']);
        }
    }
}