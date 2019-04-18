<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.04.2019
 * Time: 0:26
 */

namespace app\base;


use app\models\ActivityForm;

interface IActivityStorage
{
    public function save(ActivityForm $model);
}