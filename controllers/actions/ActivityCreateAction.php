<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 19:02
 */

namespace app\controllers\actions;


use app\components\ActivityComponent;
use app\models\Activity;
use yii\base\Action;
use yii\base\Component;

class ActivityCreateAction extends Action
{
    public function run() {

        /** @var ActivityComponent $comp */


        /** @var ActivityComponent $app->activity */
        //$comp = \Yii::$app->activity;

        $comp = \Yii::createObject([
            'class' => ActivityComponent::class,
            'model_class' => Activity::class
        ]);

        $model = $comp->getModel();

        if (\Yii::$app->request->isPost) {
            if ($comp->createActivity($model, \Yii::$app->request->post())) {

            }
        }

        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }
}