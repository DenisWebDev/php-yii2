<?php


namespace app\behaviors;


use yii\base\Behavior;

class DateCreatedBehavior extends Behavior
{
    public  $attribute_name;

    public function getDateCreated(){
        return \Yii::$app->formatter->asDatetime(strtotime($this->owner->{$this->attribute_name}),
            'php:d.m.Y H:i:s');
    }
}