<?php

namespace app\models;

use app\behaviors\DemoLogBehavior;
use app\modules\auth\models\User;
use yii\helpers\ArrayHelper;

/**
 * @property User $user
 */

class ActivityRecord extends ActivityRecordBase
{
    public function behaviors()
    {
        return [
            DemoLogBehavior::class
        ];
    }

    public function rules()
    {
        $rules = parent::rules();
        foreach ($rules as $key => $rule) {
            if (ArrayHelper::getValue($rule, '0.0') == 'user_id'
                && ArrayHelper::getValue($rule, '1') == 'exist'
            ) {
                unset($rules[$key]);
            }
        }
        return array_merge($rules, [
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']],
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function fields()
    {
        return [
            'id','title','user_id','date_start',
            'user_email'=>function($model){
                return $model->user->email;
            }
        ];
    }

    public function extraFields()
    {
        return ['email','date_add'];
    }

}
