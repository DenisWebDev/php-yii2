<?php


namespace app\components;


use app\base\ILogger;
use yii\helpers\Console;

class ConsoleLogger implements ILogger
{

    public function success($message)
    {
        echo Console::ansiFormat($message, [Console::FG_GREEN]).PHP_EOL;
    }

    public function error($message)
    {
        echo Console::ansiFormat($message, [Console::FG_RED]).PHP_EOL;
    }
}