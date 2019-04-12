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
        return strtotime(
            $this->owner->{$this->attribute_name} );
    }

}