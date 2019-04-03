<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:17
 */

namespace app\components;


use yii\base\Component;
use yii\db\ActiveRecord;

class SessionStorageComponent extends Component implements StorageInterface
{
    public function add(ActiveRecord $model)
    {
        $table = $model->tableName();
        $data = $model->attributes;

        $storage_data = $this->getData($table);
        $keys = array_keys($storage_data);
        $key = reset($keys) + 1;
        $storage_data[$key] = $data;

        $this->setData($table, $storage_data);

        return $key;
    }

    public function get(ActiveRecord $model, $id)
    {
        $table = $model->tableName();
        $storage_data = $this->getData($table);
        $data = array_key_exists($id, $storage_data) ? $storage_data[$id] : [];
        $model->attributes = $data;
        return $model;
    }

    public function getList(ActiveRecord $model, $options = [])
    {
        $table = $model->tableName();
        return $this->getData($table);
    }

    private function getData($table)
    {
        return \Yii::$app->session->get('storage_'.$table, []);
    }

    private function setData($table, $data) {
        \Yii::$app->session->set('storage_'.$table, $data);
    }
}