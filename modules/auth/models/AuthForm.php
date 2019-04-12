<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.04.2019
 * Time: 0:12
 */

namespace app\modules\auth\models;


use yii\base\Model;

class AuthForm extends Model
{
    public $email;

    public $password;

    const SCENARIO_SIGN_UP = 'sign-up';

    const SCENARIO_SIGN_IN = 'sign-in';

    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'password'], 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('app', 'Пароль')
        ];
    }

    public function setSignUpScenario()
    {
        $this->setScenario(static::SCENARIO_SIGN_UP);
    }

    public function setSignInScenario()
    {
        $this->setScenario(static::SCENARIO_SIGN_IN);
    }


}