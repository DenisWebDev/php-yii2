<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2019
 * Time: 22:51
 */

namespace app\behaviors;


use app\components\ActivityBaseComponent;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\log\Logger;

class DemoLogBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'demoLog',
            ActiveRecord::EVENT_AFTER_INSERT => 'demoLog',
            ActivityBaseComponent::EVENT_LOAD_IMAGES => 'demoLogImages',
        ];
    }

    public function demoLog()
    {
        \Yii::getLogger()->log('DemoLogBehavior:demoLog', Logger::LEVEL_WARNING);
    }

    public function demoLogImages()
    {
        \Yii::getLogger()->log('DemoLogBehavior:demoLogImages', Logger::LEVEL_WARNING);
    }

}