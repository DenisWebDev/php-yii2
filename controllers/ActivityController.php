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
        /** @var ActivityComponent $component */
        $component = \Yii::$app->activity;

        /** @var Activity $model */
        $model = $component->getModel();

        $component = \Yii::createObject(['class' => SessionStorageComponent::class]);

        $model = $component->get('activity_demo', $model);

        return $this->render('index',
            ['model' => $model]
        );
    }

}