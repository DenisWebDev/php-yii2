<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:17
 */

namespace app\components;


use yii\base\Component;

class SessionStorageComponent extends Component implements StorageInterface
{
    public function add($table, $data)
    {
       $storage_data = $this->getData($table);
       $keys = array_keys($storage_data);
       $key = reset($keys) + 1;
       $storage_data[$key] = $data;
       $this->setData($table, $storage_data);
       return $key;
    }

    public function get($table, $id)
    {
        $storage_data = $this->getData($table);
        return array_key_exists($id, $storage_data) ? $storage_data[$id] : [];
    }

    public function getList($table, $options = [])
    {
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