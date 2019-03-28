<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:17
 */

namespace app\components;


use yii\base\Component;
use yii\base\Model;

class SessionStorageComponent extends Component
{
    public function save($key, Model $model) {
        \Yii::$app->session->set($key, $model->attributes);
    }

    public function get($key, Model $model) {
        if ($data = \Yii::$app->session->get($key)) {
            $model->attributes = $data;
        }
        return $model;
    }
}