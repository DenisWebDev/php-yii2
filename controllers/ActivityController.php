<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2019
 * Time: 23:52
 */

namespace app\controllers;


use app\base\BaseController;
use app\components\ActivityComponent;
use app\models\Activity;
use app\modules\auth\models\User;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;

class ActivityController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @throws HttpException
     */
    public function actionCreate()
    {
        if (!\Yii::$app->rbac->canCreateActivity()) {
            throw new HttpException(403,'У вас нет прав создавать события');
        }

        $component = $this->getComponent();

        /** @var Activity $model */
        $model = $component->getActivityFormModel();
        $model->user_id = \Yii::$app->user->getId();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post())) {
            try {
                if ($id = $component->createActivity($model)) {
                    \Yii::$app->session->setFlash('success', 'Событие успешно добавлено');
                    return $this->redirect(Url::to(['activity/view', 'id' => $id]));
                }
            } catch (UserException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return ActivityComponent
     */
    public function getComponent()
    {
        $component = \Yii::$app->activity;
        return $component;
    }

}