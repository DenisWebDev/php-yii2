<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31.03.2019
 * Time: 14:10
 */

namespace app\controllers;


use app\base\BaseController;
use app\components\DaoComponent;
use yii\filters\PageCache;
use yii\helpers\Url;

class DaoController extends BaseController
{
    public function behaviors()
    {
        return [
            ['class' => PageCache::class, 'only' => ['index'],
                'duration' => 6]
        ];
    }

    private function daoComponent()
    {
        return \Yii::createObject([
            'class' => DaoComponent::class
        ]);
    }

    public function actionIndex()
    {
        $component = $this->daoComponent();

        $options = [];
        if ($user_id = \Yii::$app->request->get('user_id')) {
            $options['user_id'] = $user_id;
        }
        if ($user_email = \Yii::$app->request->get('user_email')) {
            $options['user_email'] = $user_email;
        }


        $data = $component->getActivities($options);
        $rand_user_id = $component->getRandActivityUserId();
        $rand_user_email = $component->getRandActivityUserEmail();

        return $this->render('index', [
            'data' => $data,
            'rand_user_id' => $rand_user_id,
            'rand_user_email' => $rand_user_email
        ]);
    }

    public function actionClear()
    {
        $this->daoComponent()->clear();
        \Yii::$app->session->setFlash('success', 'Данные очищены');
        return $this->redirect(Url::to(['dao/index']));
    }

    public function actionAdd()
    {
        $this->daoComponent()->addRandomData();
        \Yii::$app->session->setFlash('success', 'Данные созданы');

        return $this->redirect(Url::to(['dao/index']));
    }


}