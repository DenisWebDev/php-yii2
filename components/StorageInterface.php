<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.03.2019
 * Time: 1:16
 */

namespace app\components;


use yii\db\ActiveRecord;

interface StorageInterface
{
    public function add(ActiveRecord $model);

    public function get(ActiveRecord $model, $id);

    public function getList(ActiveRecord $model, $options = []);

}