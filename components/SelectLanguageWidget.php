<?php

namespace app\components;

use yii\base\Widget;
use yii\bootstrap\Html;

class SelectLanguageWidget extends Widget
{
    public function run() {
        if(\Yii::$app->language == 'ru') {
            return Html::a('Go to English', [\Yii::$app->controller->route, 'language' => 'en']);
        } else {
            return Html::a('Перейти на русский', [\Yii::$app->controller->route, 'language' => 'ru']);
        }
    }
}