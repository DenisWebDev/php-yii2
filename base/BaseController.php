<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 18:38
 */

namespace app\base;


use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class BaseController extends Controller
{
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        $url = \Yii::$app->request->url;
        \Yii::$app->session->set('last_page_url', $url);

        return $result;
    }

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', 'Требуется авторизация');
            return $this->redirect(Url::to(['/auth/default/sign-in']));
        }
        return parent::beforeAction($action);
    }

}