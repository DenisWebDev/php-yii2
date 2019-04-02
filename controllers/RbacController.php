<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.04.2019
 * Time: 22:30
 */

namespace app\controllers;


use app\base\BaseController;
use yii\db\Query;

class RbacController extends BaseController
{
    public function actionInit()
    {
        \Yii::$app->rbac->init();

        $data = [];
        foreach(['auth_item', 'auth_item_child', 'auth_assignment', 'auth_rule'] as $table) {
            $data[$table] = (new Query())->select('*')
                ->from($table)->all();
        }

        return $this->render('init', ['data' => $data]);
    }

}