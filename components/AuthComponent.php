<?php


namespace app\components;


use app\models\Users;
use yii\base\Component;

class AuthComponent extends Component
{

    /**
     * @param null $params
     * @return Users
     */
    public function getModel($params=null){
        $model=new Users();
        if($params){
            $model->load($params);
        }

        return $model;
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function createUser(&$model):bool{
        if(!$model->validate(['password','email'])){
            return false;
        }

        $model->password_hash=$this->generatePasswordHash($model->password);

        $model->auth_key=$this->generateAuthKey();

        if(!$model->save()){
            return false;
        }

        return true;
    }

    private function generateAuthKey(){
        return \Yii::$app->security->generateRandomString();
    }

    public function generatePasswordHash($password){
        return \Yii::$app->security->generatePasswordHash($password);
    }

}