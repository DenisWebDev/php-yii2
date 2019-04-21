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
use app\models\ActivityForm;
use app\models\ActivitySearch;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ActivityController extends BaseController
{
    public function actionIndex()
    {
        $model = new ActivitySearch();
        $model->showUser = \Yii::$app->rbac->editViewAllActivity();
        $provider = $model->getDataProvider(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'provider' => $provider
        ]);

    }

    /**
     * @return array|string|Response
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        if (!\Yii::$app->rbac->canCreateActivity()) {
            throw new HttpException(403,'У вас нет прав создавать события');
        }

        $component = $this->getComponent();

        /** @var ActivityForm $model */
        $model = $component->getActivityFormModel();
        $model->user_id = \Yii::$app->user->getId();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');
            try {
                if ($id = $component->saveActivity($model)) {
                    \Yii::$app->session->setFlash('success', 'Событие успешно добавлено');
                    return $this->redirect(Url::to(['/activity']));
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
     * @param $id
     * @return array|string|Response
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        if (!\Yii::$app->rbac->canCreateActivity()) {
            throw new HttpException(403, 'У вас нет прав создавать события');
        }

        $component = $this->getComponent();

        $model = $component->getActivityFormModel($id);

        if (!$model) {
            throw new NotFoundHttpException('Событие не найдено');
        }
        if (!\Yii::$app->rbac->canViewActivity($model)){
            throw new HttpException(403, 'У вас нет прав редактирования данного события');
        }

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');
            try {
                if ($id = $component->saveActivity($model)) {
                    \Yii::$app->session->setFlash('success', 'Событие успешно обновлено');
                    return $this->redirect(Url::to(['/activity']));
                }
            } catch (UserException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
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