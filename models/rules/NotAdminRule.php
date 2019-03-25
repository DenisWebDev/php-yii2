<?php
/**
 * Created by PhpStorm.
 * User: Talisman
 * Date: 25.03.2019
 * Time: 19:58
 */

namespace app\models\rules;


use yii\validators\Validator;

class NotAdminRule extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if($model->$attribute=='admin'){
            $model->addError($attribute,'Значения заголовка не должно быть admin');
        }
    }
}