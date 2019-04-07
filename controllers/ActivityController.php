<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 18:32
 */

namespace app\controllers;


use app\base\BaseController;
use app\controllers\actions\ActivityCreateAction;
use yii\web\HttpException;

class ActivityController extends BaseController
{
    public function actions()
    {
        return [
            'create' => ['class' => ActivityCreateAction::class]
        ];
    }

    public function actionIndex()
    {
        $data = \Yii::$app->activity->getActivities();
        return $this->render('index', ['data' => $data]);
    }

    public function actionView($id) {

        $model = \Yii::$app->activity->getActivity($id);

        if (!$model){
            throw new HttpException(401, 'Событите не найдено');
        }
        if (!\Yii::$app->rbac->canViewActivity($model)){
            throw new HttpException(403,'У вас нет прав просмотра данного события');
        }

        return $this->render('view',
            ['model' => $model]
        );
    }

}