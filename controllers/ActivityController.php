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
        return $this->render('index');
    }

    public function actionView($id) {

        $model = \Yii::$app->activity->getActivity($id);

        return $this->render('view',
            ['model' => $model]
        );
    }

}