<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;

class ActivitySearch extends Activity
{
    public function getDataProvider($params){

        $model=new Activity();

        $query=$model::find();

        $this->load($params);

        $provoider=new ActiveDataProvider([
            'query'=>$query,
            'pagination' => [
                'pageSize'=>5
            ],
            'sort' => [
                'defaultOrder'=>[
                    'id'=>SORT_DESC
                ]
            ]
        ]);



        $query->andFilterWhere(['like','email',$this->email]);
        $query->with('user');

        return $provoider;

    }
}