<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.04.2019
 * Time: 22:51
 */

namespace app\components;


use app\rules\ViewOwnerActivityRule;
use yii\base\Component;

class RbacComponent extends Component
{
    private function getAuthManager()
    {
        return \Yii::$app->authManager;
    }

    /**
     * @throws \Exception
     */
    public function initRbac()
    {
        $authManager = $this->getAuthManager();

        $authManager->removeAll();

        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');

        $authManager->add($admin);
        $authManager->add($user);

        $create_activity = $authManager->createPermission('createActivity');
        $create_activity->description = 'Создание события';

        $authManager->add($create_activity);

        $viewRule = new ViewOwnerActivityRule();
        $authManager->add($viewRule);

        $view_activity = $authManager->createPermission('viewActivity');
        $view_activity->description = 'Просмотр события';
        $view_activity->ruleName = $viewRule->name;

        $authManager->add($view_activity);

        $editViewAllActivity = $authManager->createPermission('editViewAllActivity');
        $editViewAllActivity->description = 'Просмотр и редактированию любых событий';
        $authManager->add($editViewAllActivity);

        $authManager->addChild($user, $create_activity);
        $authManager->addChild($user, $view_activity);

        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $editViewAllActivity);

    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function assignAdminRole($id)
    {
        $authManager = $this->getAuthManager();
        $admin = $authManager->getRole('admin');
        $authManager->assign($admin, $id);
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function assignUserRole($id)
    {
        $authManager = $this->getAuthManager();
        $admin = $authManager->getRole('user');
        $authManager->assign($admin, $id);
    }

    public function canCreateActivity():bool
    {
        return \Yii::$app->user->can('createActivity');
    }

    public function canViewActivity($activity):bool
    {
        if (\Yii::$app->user->can('editViewAllActivity')) {
            return true;
        }

        if (\Yii::$app->user->can('viewActivity', [
            'activity' => $activity
        ])) {
            return true;
        }

        return false;
    }

    public function editViewAllActivity():bool
    {
        return \Yii::$app->user->can('editViewAllActivity');
    }
}