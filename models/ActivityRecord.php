<?php

namespace app\models;

use app\modules\auth\models\User;
use yii\helpers\ArrayHelper;

class ActivityRecord extends ActivityRecordBase
{
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

}
