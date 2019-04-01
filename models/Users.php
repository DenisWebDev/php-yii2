<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $token
 * @property string $date_add
 *
 * @property Activity[] $activities
 */
class Users extends UsersBase
{
    public $password;

    public function rules()
    {
        return array_merge([
            ['password','string','min'=>6],
            ['email','email']
        ],parent::rules());
    }
}
