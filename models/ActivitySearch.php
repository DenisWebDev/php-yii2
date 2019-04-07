<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2019
 * Time: 20:09
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class ActivitySearch extends ActivityRecord
{
    public function getDataProvider($params)
    {
        $model = new ActivityRecord();

        $query = $model::find();

        $this->load($params, 'ActivitySearch');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        $query->with('user');

        return $provider;
    }

}