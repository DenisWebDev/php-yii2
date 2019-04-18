<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.04.2019
 * Time: 0:10
 */

namespace app\modules\auth\components;


use app\modules\auth\models\AuthForm;
use app\modules\auth\models\User;
use yii\base\Component;
use yii\base\InvalidArgumentException;
use yii\base\UserException;

class AuthComponent extends Component
{
    public $authFormModel;

    public $userModel;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (!$this->authFormModel) {
            throw new \Exception('Need authFormModel param');
        }
        if (!$this->userModel) {
            throw new \Exception('Need userModel param');
        }
    }

    public function getSignUpFormModel()
    {
        /** @var AuthForm $model */
        $model = new $this->authFormModel();
        $model->setSignUpScenario();
        return $model;
    }

    public function getSignInFormModel()
    {
        /** @var AuthForm $model */
        $model = new $this->authFormModel();
        $model->setSignInScenario();
        return $model;
    }

    public function getUserModel()
    {
        /** @var User $model */
        $model = new $this->userModel();
        return $model;
    }

    /**
     * @param AuthForm $model
     * @return bool
     * @throws UserException
     * @throws \yii\base\Exception
     */
    public function signIn($model):bool
    {
        if (!$model->validate()) {
            return false;
        }

        if ($user = $this->getUserModel()::findOne(['email' => $model->email])) {
            if (!$this->checkPassword($model->password, $user->password_hash)) {
                $model->addError('password','Неправильный пароль');
                return false;
            }
            $user->auth_key = $this->generateAuthKey();
            $user->save();
            if (\Yii::$app->user->login($user, 60*60*24)) {
                return true;
            }
        }

        throw new UserException('Ошибка авторизации');
    }


    /**
     * @param AuthForm $model
     * @return bool
     * @throws UserException
     * @throws \yii\base\Exception
     */
    public function createUser($model):bool
    {
        if (!$model->validate()) {
            return false;
        }

        if ($user = $this->addNewUser($model->email, $model->password)) {
            \Yii::$app->rbac->assignUserRole($user->id);
            \Yii::$app->user->login($user, 60*60*24);
            return true;
        }

        throw new UserException('Регистрация временно недоступна');
    }

    /**
     * @param $email
     * @param $password
     * @return bool|User
     * @throws \yii\base\Exception
     */
    public function addNewUser($email, $password)
    {
        $user = $this->getUserModel();
        $user->email = $email;
        $user->password_hash = $this->generatePasswordHash($password);
        $user->auth_key = $this->generateAuthKey();
        $user->access_token = $this->generateAccessToken();
        if ($user->save()) {
            return $user;
        }
        return false;
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePasswordHash($password)
    {
        return \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        return \Yii::$app->security->generateRandomString();
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAccessToken()
    {
        return \Yii::$app->security->generateRandomString(64);
    }

    private function checkPassword($password, $password_hash):bool
    {
        try {
            return \Yii::$app->security->validatePassword($password, $password_hash);
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }





}