<?php

namespace app\components;

use yii\base\Widget;
use yii\bootstrap\Html;

class SelectLanguageWidget extends Widget
{
    public function run() {
        if(\Yii::$app->language == 'ru') {
            return Html::a('Go to English', array_merge(
                \Yii::$app->request->get(),
                ['/' . \Yii::$app->controller->route, 'language' => 'en']
            ));
        } else {
            return Html::a('Перейти на русский', array_merge(
                \Yii::$app->request->get(),
                ['/' . \Yii::$app->controller->route, 'language' => 'ru']
            ));
        }
    }
}