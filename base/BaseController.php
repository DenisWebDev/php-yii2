<?php

namespace app\base;

use yii\web\Controller;
use yii\web\HttpException;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2019
 * Time: 23:53
 */

class BaseController extends Controller
{

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest) {
            throw new HttpException(401,'Требуется авторизация');
        }
        return parent::beforeAction($action);
    }

}