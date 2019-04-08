<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2019
 * Time: 19:53
 */

namespace app\widgets\daotable;


use yii\bootstrap\Widget;

class DaoTableWidget extends Widget
{
    public $activities;

    public function run()
    {
        return $this->render('index', [
            'data' => $this->activities
        ]);
    }

}