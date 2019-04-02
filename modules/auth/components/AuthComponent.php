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

}