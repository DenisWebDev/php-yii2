<?php


namespace app\components;


use app\base\ILogger;
use yii\helpers\Console;

class ConsoleLogger implements ILogger
{

    public function log($message)
    {
        echo Console::ansiFormat($message,[Console::FG_GREEN]).PHP_EOL;
    }
}