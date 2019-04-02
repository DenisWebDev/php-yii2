<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01.04.2019
 * Time: 23:43
 */

namespace app\modules\auth\models;


class User extends UserBase
{

    public $password;

    public function rules()
    {
        return array_merge([
            ['password', 'required'],
            ['password', 'string', 'min' => 6]
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль'
        ];
    }

}