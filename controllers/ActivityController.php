<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2019
 * Time: 23:52
 */

namespace app\controllers;


use app\base\BaseController;

class ActivityController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}