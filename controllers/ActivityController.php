<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 18:32
 */

namespace app\controllers;


use app\base\BaseController;
use app\components\ActivityComponent;
use app\components\SessionStorageComponent;
use app\controllers\actions\ActivityCreateAction;
use app\models\Activity;

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
        /** @var Activity $model */
        $model = \Yii::$app->activity->getActivity();

        return $this->render('index',
            ['model' => $model]
        );
    }

}