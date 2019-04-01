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
    public function authUser(&$model):bool{
        $model->setAuthScenario();
        if(!$model->validate(['email','password'])){
            return false;
        }
        $password=$model->password;

        $model=$model::findOne(['email'=>$model->email]);

        $model->auth_key=$this->generateAuthKey();

        $model->save();

        if(!$this->checkPassword($password,$model->password_hash)){
            $model->addError('password','Пароль не пршел проверку');
            return false;
        }

        if(!\Yii::$app->user->login($model,3600)){
            return false;
        }

        return true;


    }


    private function checkPassword($password,$password_hash):bool{
        return \Yii::$app->security->validatePassword($password,$password_hash);
    }

    /**
     * @param $model Users
     * @return bool
     */
    public function createUser(&$model):bool{
        $model->setRgisterScenario();
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