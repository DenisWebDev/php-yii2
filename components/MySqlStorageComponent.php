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

class MySqlStorageComponent extends Component implements StorageInterface
{
    /**
     * @param ActiveRecord $model
     * @return integer
     */
    public function add(ActiveRecord $model)
    {
        $model->save(false);
        return $model->id;
    }

    public function get(ActiveRecord $model, $id)
    {
        return $model::find()->where(['id' => $id])->one();
    }

    public function getList(ActiveRecord $model, $options = [])
    {
        return $model::find()->all();
    }

}