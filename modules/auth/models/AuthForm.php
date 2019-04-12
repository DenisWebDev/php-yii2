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

    /*
     * С точки зрения безопасности нельзя сообщать о том,
     * что пользователь с таким-то email не найден.
     * Используется только для демонстрации фильтра exist
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'password'], 'required'],
            ['email', 'unique', 'targetClass' => 'app\modules\auth\models\User',
                'on' => static::SCENARIO_SIGN_UP],
            ['email', 'exist', 'targetClass' => 'app\modules\auth\models\User',
                'on' => static::SCENARIO_SIGN_IN,
                'message' => \Yii::t('app', 'Пользователь с данным email не зарегистрирован')],
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