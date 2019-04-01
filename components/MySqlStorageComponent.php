<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 13:17
 */

namespace app\components;


use yii\base\Component;
use yii\db\Query;

class MySqlStorageComponent extends Component implements StorageInterface
{
    /**
     * @param $table string
     * @param $data array
     * @return integer
     * @throws \yii\db\Exception
     */
    public function add($table, $data)
    {
        \Yii::$app->db->createCommand()
            ->insert($table, $data)
            ->execute();
        return \Yii::$app->db->getLastInsertID();
    }

    public function get($table, $id)
    {
        $data = (new Query())->select('*')
            ->from($table)
            ->where(['id' => $id])
            ->limit(1)
            ->one();
        return $data ? $data : [];
    }

    public function getList($table, $options = [])
    {
        $data = (new Query())->select('*')
            ->from($table)
            ->all();
        return $data;
    }

}