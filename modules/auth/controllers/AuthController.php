<?php

namespace app\modules\auth\controllers;

use app\modules\auth\components\AuthComponent;
use yii\base\UserException;
use yii\helpers\Url;
use yii\web\Controller;

class AuthController extends Controller
{
    /**
     * @return AuthComponent
     */
    private function getComponent()
    {
        return \Yii::$app->auth;
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = $this->getComponent()->getSignInFormModel();

        if ($model->load(\Yii::$app->request->post())) {
            try {
                if ($this->getComponent()->signIn($model)) {
                    return $this->goHome();
                }
            } catch (UserException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signIn', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionSignUp()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = $this->getComponent()->getSignUpFormModel();

        if ($model->load(\Yii::$app->request->post())) {
            try {
                if ($this->getComponent()->createUser($model)) {
                    return $this->goHome();
                }
            } catch (UserException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('signUp', ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(Url::to([\Yii::$app->defaultRoute]));
    }
}
