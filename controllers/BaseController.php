<?php

namespace app\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    public function actions() {
        $controllerId = \Yii::$app->controller->uniqueId;
        $dirPath = __DIR__ . DIRECTORY_SEPARATOR . $controllerId;
        if(!is_dir($dirPath)) {
            return [];
        }

        $actions = [];
        $dir = new \DirectoryIterator($dirPath);
        foreach($dir as $item) {
            if($item->isFile()) {
                $actionId = lcfirst(str_replace(['Action', '.' . $item->getExtension()], '', $item->getBasename()));
                $actionClassName = __NAMESPACE__ . '\\' . $controllerId . '\\'
                    . str_replace('.' . $item->getExtension(), '', $item->getBasename());
                $actions[$actionId] = $actionClassName;
            }
        }

        return $actions;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $assetFileName = str_replace('/', '-', \Yii::$app->controller->route);

        $cssFilePath = '/css/pages/' . $assetFileName . '.css';
        if(file_exists(\Yii::getAlias('@webroot' . $cssFilePath))) {
            \Yii::$app->view->registerCssFile('@web' . $cssFilePath);
        }

        $jsFilePath = '/js/pages/' . $assetFileName . '.js';
        if(file_exists(\Yii::getAlias('@webroot' . $jsFilePath))) {
            \Yii::$app->view->registerJsFile('@web' . $jsFilePath);
        }

        return true;
    }
}