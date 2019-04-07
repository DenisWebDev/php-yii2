<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2019
 * Time: 22:27
 */

namespace app\behaviors;


use yii\base\Behavior;

class DateCreatedBehavior extends Behavior
{
    public $attribute_name;

    public function getDateCreated()
    {
        return \Yii::$app->formatter->asDatetime(
            $this->owner->{$this->attribute_name},
            'php:d.m.Y H:i:s'
        );
    }

}