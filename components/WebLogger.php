<?php


namespace app\components;


use app\base\ILogger;
use yii\log\Logger;

class WebLogger implements ILogger
{

    public function log($message)
    {
        \Yii::getLogger()->log($message,Logger::LEVEL_INFO);
    }
}