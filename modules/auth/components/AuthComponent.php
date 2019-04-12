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
     */
    public function signIn($model):bool
    {
        if (!$model->validate()) {
            return false;
        }
        return false;
    }

    /**
     * @param AuthForm $model
     * @return bool
     */
    public function createUser($model):bool
    {
        if (!$model->validate()) {
            return false;
        }
        return false;
    }





}