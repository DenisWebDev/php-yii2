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
use app\models\Activity;
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
        return $this->render('index');
    }

    public function actionView($id) {

        $model =Activity::find()->andWhere(['id'=>$id])->one(); // \Yii::$app->activity->getActivity($id);

        if(!$model){
            throw new HttpException(401,'activity not found');
        }
        if(!\Yii::$app->rbac->canViewActivity($model)){
            throw new HttpException(403,'not access show activity');
        }

        return $this->render('view',
            ['model' => $model]
        );
    }

}