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
        // TODO временно готовим данные тут
        $data['user_id'] = 1;
        unset($data['images']);
        if ($data['date_start']) {
            $data['date_start'] = \DateTime::createFromFormat('d.m.Y', $data['date_start'])
                ->format('Y-m-d');
        }
        if ($data['date_end']) {
            $data['date_end'] = \DateTime::createFromFormat('d.m.Y', $data['date_end'])
                ->format('Y-m-d');
        }
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