<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

class Activity extends ActivityBase
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = TimestampBehavior::class;
        return $behaviors;
    }

    public function beforeValidate()
    {
        /*
         * Т.к. некорректно работает TimestampBehavior
         * для полей БД без значений по умолчанию
         */

        if ($this->created_at === null && $this->isNewRecord) {
            $this->created_at = time();
        }
        if ($this->updated_at === null) {
            $this->updated_at = time();
        }
        return parent::beforeValidate();
    }


}
