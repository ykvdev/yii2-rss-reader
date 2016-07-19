<?php

namespace app\components;

use yii\base\View;
use yii\helpers\Html;

class ViewRenderer extends \yii\base\ViewRenderer
{
    /**
     * Renders a view file.
     *
     * This method is invoked by [[View]] whenever it tries to render a view.
     * Child classes must implement this method to render the given view file.
     *
     * @param View $view the view object used for rendering the file.
     * @param string $file the view file.
     * @param array $params the parameters to be passed to the view file.
     * @return string the rendering result
     */
    public function render($view, $file, $params)
    {
        $this->encodeParams($params);
        return $view->renderPhpFile($file, $params);
    }

    private function encodeParams(&$params) {
        foreach($params as $name => &$value) {
            if(is_string($value) && substr($name, 0, 1) != '_' && $name != 'content') {
                $value = Html::encode($value);
            }
        }
    }
}