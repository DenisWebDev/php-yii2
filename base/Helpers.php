<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2019
 * Time: 0:18
 */

namespace app\base;


use yii\helpers\Html;

class Helpers
{

    public static function _d($expression, $return = false)
    {
        ob_start();
        if (is_bool($expression) or is_null($expression)) {
            var_dump($expression);
        } else {
            print_r($expression);
        }
        $output = Html::tag('pre', ob_get_clean());
        if (!$return) {
            echo $output;
            return null;
        }
        return $output;
    }

}