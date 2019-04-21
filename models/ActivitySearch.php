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
    public $showUser = false;

    public function getDataProvider($params)
    {

        $model = new Activity();

        $query = $model::find();

        $this->load($params, 'ActivitySearch');

        $provider = new ActiveDataProvider([
            'query' => $query
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->showUser) {
            $query->with('user');
        } else {
            $query->andWhere(['user_id' => \Yii::$app->user->id]);
        }

        return $provider;

    }

}