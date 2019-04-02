<?php

namespace app\modules\auth\controllers;

use app\modules\auth\components\AuthComponent;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `auth` module
 */
class DefaultController extends Controller
{
    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionSignUp()    {

        $model = $this->authComponent()->getModel();

        if (\Yii::$app->request->isPost) {
            $model = $this->authComponent()->getModel(\Yii::$app->request->post());

            if ($this->authComponent()->createUser($model)) {
                return $this->redirect(Url::to(['default/sign-in']));
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Для подсказок в редакторе
     * @return AuthComponent
     */
    private function authComponent() {
        return \Yii::$app->auth;
    }
}
