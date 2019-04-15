<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2019
 * Time: 22:57
 */

namespace app\commands;


use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    public function actionInit()
    {
        \Yii::$app->rbac->initRbac();
        echo $this->ansiFormat('success', Console::FG_GREEN).PHP_EOL;
    }
}