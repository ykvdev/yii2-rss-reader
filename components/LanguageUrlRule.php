<?php

namespace app\components;

use yii\web\UrlRule;

// https://github.com/samdark/yii2-cookbook/blob/master/book/i18n-selecting-application-language.md
class LanguageUrlRule extends UrlRule
{
    public function init()
    {
        if ($this->pattern !== null) {
            $this->pattern = '<currentLanguage>/' . $this->pattern;
        }
        $this->defaults['currentLanguage'] = \Yii::$app->language;
        parent::init();
    }
}