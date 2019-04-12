<?php


namespace app\widgets\daotable;


use yii\base\Widget;

class DaoTableWidget extends Widget
{

    public $activities;

    public function run()
    {
        return $this->render('index',['data'=>$this->activities]);
    }
}