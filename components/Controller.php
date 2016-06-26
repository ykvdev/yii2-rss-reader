<?php

namespace app\components;

class Controller extends \yii\web\Controller
{
    public function actions() {
        $moduleId = \Yii::$app->controller->module->id;
        $controllerId = \Yii::$app->controller->id;
        $actionsPath = \Yii::getAlias("@app/modules/{$moduleId}/controllers/{$controllerId}");
        if(!is_dir($actionsPath)) {
            return [];
        }

        $actions = [];
        $dir = new \DirectoryIterator($actionsPath);
        foreach($dir as $item) {
            if($item->isFile()) {
                $actionId = lcfirst(str_replace(['Action', '.' . $item->getExtension()], '', $item->getBasename()));
                $actionId = preg_replace('/([A-Z]{1})/', '-$1', $actionId);
                $actionId = strtolower($actionId);

                $actionClassName = "app\\modules\\{$moduleId}\\controllers\\{$controllerId}\\"
                    . str_replace('.' . $item->getExtension(), '', $item->getBasename());

                $actions[$actionId] = $actionClassName;
            }
        }

        return $actions;
    }
}