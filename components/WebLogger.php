<?php


namespace app\components;


use app\base\ILogger;
use yii\log\Logger;

class WebLogger implements ILogger
{

    public function success($message)
    {
        \Yii::getLogger()->log($message, Logger::LEVEL_INFO);
    }

    public function error($message)
    {
        \Yii::getLogger()->log($message, Logger::LEVEL_WARNING);
    }
}