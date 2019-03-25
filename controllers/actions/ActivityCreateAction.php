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
use yii\helpers\Html;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ActivityCreateAction extends Action
{
    public function run() {

        /** @var ActivityComponent $comp */
        $comp = \Yii::$app->activity;

        /** @var Activity $model */
        $model = $comp->getModel();

        if (\Yii::$app->request->isPost) {
            if(\Yii::$app->request->isAjax){
                \Yii::$app->response->format=Response::FORMAT_JSON;
                $model->load(\Yii::$app->request->post());
//                print_r($model->validate()?'ok':'no');exit;
                return ActiveForm::validate($model);
            }

            if ($comp->createActivity($model, \Yii::$app->request->post())) {
                return $this->controller->render('view',['model'=>$model]);
            }
        }

        return $this->controller->render('create', [
            'model' => $model,
        ]);
    }
}