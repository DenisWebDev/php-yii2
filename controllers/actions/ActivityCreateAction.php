<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 19:02
 */

namespace app\controllers\actions;


use app\components\ActivityBaseComponent;
use app\models\Activity;
use yii\base\Action;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;

class ActivityCreateAction extends Action
{
    /**
     * @return array|string|Response
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run() {

        if (!\Yii::$app->rbac->canCreateActivity()) {
            throw new HttpException(403,'У вас нет прав создавать события');
        }

        /** @var ActivityBaseComponent $component */
        $component = \Yii::$app->activity;

        /** @var Activity $model */
        $model = $component->getModel();

        if (\Yii::$app->request->isPost) {
            if(\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                $model->load(\Yii::$app->request->post());
                return ActiveForm::validate($model);
            }
            if ($id = $component->createActivity(
                $model,
                \Yii::$app->request->post(),
                \Yii::$app->user->getId()
            )) {
                \Yii::$app->session->setFlash('success', 'Success');
                return $this->controller->redirect(Url::to(['activity/view', 'id' => $id]));
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }
}