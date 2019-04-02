<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01.04.2019
 * Time: 23:45
 */

namespace app\modules\auth\components;


use app\modules\auth\models\User;
use yii\base\Component;
use yii\base\InvalidArgumentException;

class AuthComponent extends Component
{
    public $model_class;

    /**
     * @throws \Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->model_class)) {
            throw new \Exception('Need model_class param');
        }
    }

    public function getModel($data = [])
    {
        /** @var User $model */
        $model = new $this->model_class;

        if ($data) {
            $model->load($data);
        }

        return $model;
    }

    /**
     * @param $model User
     * @return bool
     * @throws \yii\base\Exception
     */
    public function createUser(&$model):bool
    {
        $model->setRegisterScenario();

        if (!$model->validate(['email', 'password'])) {
            return false;
        }

        $model->password_hash = $this->generatePasswordHash($model->password);
        $model->auth_key = $this->generateAuthKey();

        if (!$model->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param $model User
     * @return bool
     * @throws \yii\base\Exception
     */
    public function authUser(&$model):bool
    {
        $model->setAuthScenario();

        if (!$model->validate(['email', 'password'])){
            return false;
        }

        $password = $model->password;

        $model = $model::findOne(['email' => $model->email]);

        $model->auth_key = $this->generateAuthKey();
        $model->save();

        if (!$this->checkPassword($password, $model->password_hash)){
            $model->addError('password','Неправильный пароль');
            return false;
        }

        if (!\Yii::$app->user->login($model, (60*60*24))){
            return false;
        }

        return true;
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

    private function checkPassword($password, $password_hash):bool
    {
        try {
            return \Yii::$app->security->validatePassword($password, $password_hash);
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * @param $email
     * @param $password
     * @return int
     * @throws \yii\base\Exception
     */
    public function createDemoUser($email, $password) {
        $model = $this->getModel()::findOne(['email' => $email]);
        if ($model) {
            if (!$this->checkPassword($password, $model->password_hash)) {
                $model->password = $password;
                $model->password_hash = $this->generatePasswordHash($password);
            }
        } else {
            $model = $this->getModel();
            $model->email = $email;
            $model->password = $password;
            $this->createUser($model);
        }
        return $model->id;
    }

}