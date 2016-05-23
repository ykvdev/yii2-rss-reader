<?php

namespace app\components;

class Controller extends \yii\web\Controller
{
    public function actions() {
        $controllerId = \Yii::$app->controller->uniqueId;
        $controllerPath = \Yii::getAlias('@app/controllers/' . $controllerId);
        if(!is_dir($controllerPath)) {
            return [];
        }

        $actions = [];
        $dir = new \DirectoryIterator($controllerPath);
        foreach($dir as $item) {
            if($item->isFile()) {
                $actionId = lcfirst(str_replace(['Action', '.' . $item->getExtension()], '', $item->getBasename()));
                $actionClassName = 'app\controllers\\' . $controllerId . '\\'
                    . str_replace('.' . $item->getExtension(), '', $item->getBasename());
                $actions[$actionId] = $actionClassName;
            }
        }

        return $actions;
    }
}