<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.03.2019
 * Time: 12:26
 */

namespace app\models\rules;


use yii\validators\Validator;

class PhoneRuRule extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $phone = preg_replace('~[^0-9]~', '', $model->$attribute);
        if (strlen($phone) == 10) {
            $model->$attribute = '7'.$phone;
            return true;
        } elseif (strlen($phone) == 11) {
            if (substr($phone, 0, 1) == '7') {
                $model->$attribute = $phone;
                return true;
            }
            if (substr($phone, 0, 1) == '8') {
                $model->$attribute = '7'.substr($phone, 1);
                return true;
            }
        }
        $model->addError($attribute,'Неправильно указан номер телефона');
        return false;
    }

}