<?php


namespace app\components;


use app\rules\ViewOwnerActivityRule;
use yii\base\Component;

class RbacComponent extends Component
{
    /**
     * @return \yii\rbac\ManagerInterface
     */
    private function getAuthManager(){
        return \Yii::$app->authManager;
    }

    public function generateRbac(){
        $authManager=$this->getAuthManager();

        $authManager->removeAll();

        $admin=$authManager->createRole('admin');
        $user=$authManager->createRole('user');

        $authManager->add($admin);
        $authManager->add($user);

        $create_activity=$authManager->createPermission('create_activity');
        $create_activity->description='Создание события';

        $authManager->add($create_activity);

        $view_activity=$authManager->createPermission('view_activity');
        $view_activity->description='Просмотр события';

        $viewRule=new ViewOwnerActivityRule();
        $authManager->add($viewRule);
        $view_activity->ruleName=$viewRule->name;

        $authManager->add($view_activity);


        $editViewAllActivity=$authManager->createPermission('editViewAllActivity');
        $editViewAllActivity->description='Просмотр и редактированию любых событий';
        $authManager->add($editViewAllActivity);

        $authManager->addChild($user,$create_activity);
        $authManager->addChild($user,$view_activity);
        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$editViewAllActivity);

        $authManager->assign($admin,2);
        $authManager->assign($user,3);
    }

    public function canCreateActivity():bool{
        return \Yii::$app->user->can('create_activity');
    }

    public function canViewActivity($activity){
        if(\Yii::$app->user->can('editViewAllActivity')){
            return true;
        }

        if(\Yii::$app->user->can('view_activity',['activity'=>$activity])){
            return true;
        }

        return false;
    }
}