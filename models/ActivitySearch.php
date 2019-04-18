<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.04.2019
 * Time: 1:09
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class ActivitySearch extends Activity
{
    public function getDataProvider($params)
    {

        $model = new Activity();

        $query = $model::find();

        $this->load($params);

        $provider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $provider;

    }

}