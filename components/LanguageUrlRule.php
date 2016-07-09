<?php

namespace app\components;

use yii\web\UrlRule;

class LanguageUrlRule extends UrlRule
{
    public function init()
    {
        if ($this->pattern !== null) {
            $this->pattern = '<currentLanguage>/' . $this->pattern;
        }
        $this->defaults['currentLanguage'] = \Yii::$app->params['i18n']['default-language'];
        parent::init();
    }
}