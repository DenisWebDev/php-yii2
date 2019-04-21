<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2019
 * Time: 23:43
 */

namespace app\commands;


use yii\console\Controller;
use yii\helpers\Console;

class DemoController extends Controller
{
    public $name;

    public function options($actionID)
    {
        return ['name'];
    }

    public function optionAliases()
    {
        return [
            'n' => 'name',
        ];
    }

    public function actionCommand1($name = null)
    {
        echo 'This is terminal'.PHP_EOL;
        echo $name.PHP_EOL;
    }

    public function actionCommand2(...$args)
    {
        echo 'This is terminal'.PHP_EOL;
        print_r($args);
    }

    public function actionCommand3()
    {
        echo 'This is terminal'.PHP_EOL;
        echo $this->ansiFormat($this->name, Console::FG_GREEN).PHP_EOL;
    }

}