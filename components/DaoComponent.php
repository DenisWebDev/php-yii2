<?php


namespace app\components;


use yii\base\Component;
use yii\db\Query;
use yii\log\Logger;

class DaoComponent extends Component
{
    /**
     * @return \yii\db\Connection
     */
    public function getDb(){
        return \Yii::$app->db;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function getAllUsers(){
        $sql='select * from users';

        return $this->getDb()->createCommand($sql)->queryAll();
    }

    public function getActivityUsers($user_id){
        $sql='select * from activity where user_id=:user';

        return $this->getDb()->createCommand($sql,[':user'=>$user_id])->queryAll();
    }

    public function getUser($user){
        $query=new Query();
        return $query->select('*')
            ->from('users')
            ->andWhere(['id'=>$user])
            ->one();
    }

    public function getCountActivity(){
        $query=new Query();
        return $query->from('activity')->select('count(id) as cnt')
            ->scalar();
    }

    public function getReaderActivity(){
        $query=new Query();
        return $query->from('activity')
            ->createCommand()->query();
    }

    public function insertsAndUpdates(){

//        $r=$this->getDb()->transaction(function (){
////            $this->getDb()->createCommand()
//            return '';
//        });

        $trans=$this->getDb()->beginTransaction();
        try {
            $this->getDb()->createCommand()->insert('activity', ['title' => 'title',
                'date_start' => date('Y-m-d'), 'user_id' => 1])->execute();

//            throw new \Exception('error test');
            $this->getDb()->createCommand()->update('users', [
                'email' => mt_rand(1, 100) . '@test.ru'], ['id' => 1])->execute();

            $trans->commit();
        }catch (\Exception $e){
            \Yii::getLogger()->log($e->getMessage(),Logger::LEVEL_ERROR);
            $trans->rollBack();
        }
    }

}