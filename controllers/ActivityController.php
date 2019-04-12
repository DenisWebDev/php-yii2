<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.03.2019
 * Time: 18:32
 */

namespace app\controllers;


use app\base\BaseController;
use app\behaviors\DateCreatedBehavior;
use app\controllers\actions\ActivityCreateAction;
use app\models\ActivitySearch;
use yii\db\ActiveRecord;
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
        $model=new ActivitySearch();
        $provider=$model->getDataProvider(\Yii::$app->request->queryParams);

        return $this->render('index',['model'=>$model,'provider'=>$provider]);
    }

    public function actionView($id) {

        /** @var ActiveRecord $model */
        $model = \Yii::$app->activity->getActivity($id);

        if (!$model){
            throw new HttpException(401, 'Событите не найдено');
        }
        if (!\Yii::$app->rbac->canViewActivity($model)){
            throw new HttpException(403,'У вас нет прав просмотра данного события');
        }

        $model->attachBehavior('datecreated',[
            'class'=>DateCreatedBehavior::class,'attribute_name' => 'date_add']);
//        \Yii::$app->log();
//        $model->detachBehavior('datecreated');
        return $this->render('view',
            ['model' => $model]
        );
    }

}