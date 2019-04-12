<?php

namespace app\modules\auth\controllers;

use app\modules\auth\components\AuthComponent;
use app\modules\auth\models\AuthForm;
use app\modules\auth\models\User;
use yii\web\Controller;

class AuthController extends Controller
{
    /**
     * @return AuthComponent
     * @throws \yii\base\InvalidConfigException
     */
    private function getComponent()
    {
        $component = \Yii::createObject([
            'class' => AuthComponent::class,
            'authFormModel' => AuthForm::class,
            'userModel' => User::class
        ]);
        return $component;
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = $this->getComponent()->getSignInFormModel();

        if ($model->load(\Yii::$app->request->post())) {
            if ($this->getComponent()->signIn($model)) {
                return $this->goHome();
            }
        }

        return $this->render('signin', ['model' => $model]);

    }
}
