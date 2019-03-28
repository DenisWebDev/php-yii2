<?php


namespace app\controllers;


use app\components\DaoComponent;
use yii\web\Controller;

class DaoController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(){

        /** @var DaoComponent $copm */
        $copm=\Yii::createObject(['class'=>DaoComponent::class]);

        $copm->insertsAndUpdates();

        $users=$copm->getAllUsers();
        $activityUser=$copm->getActivityUsers(\Yii::$app->request->get('user',1));

        $user=$copm->getUser(\Yii::$app->request->get('user',1));
        $cnt=$copm->getCountActivity();
        $reader=$copm->getReaderActivity();

        return $this->render('index',['users'=>$users,
            'acitvityUser'=>$activityUser,'user'=>$user,
            'cnt'=>$cnt,'reader'=>$reader]);
    }
}