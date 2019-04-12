<?php


namespace app\behaviors;


use app\components\ActivityComponent;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\log\Logger;

class LogMyBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT=>'log',
            ActiveRecord::EVENT_AFTER_INSERT=>'log',
            ActivityComponent::EVENT_LOAD_IMAGES=>'log_image'
        ];
    }

    public function log_image(){
        \Yii::getLogger()->log('images log save',Logger::LEVEL_INFO);
    }

    public function log(){
        \Yii::getLogger()->log('log my from behavior',Logger::LEVEL_WARNING);

    }
}