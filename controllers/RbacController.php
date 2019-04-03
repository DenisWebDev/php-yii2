<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.04.2019
 * Time: 22:30
 */

namespace app\controllers;


use yii\web\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        \Yii::$app->rbac->init();

        $data = \Yii::$app->rbac->getDbData();

        return $this->render('init', ['data' => $data]);
    }

}