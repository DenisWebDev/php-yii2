<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.04.2019
 * Time: 22:28
 */

namespace app\components;


use app\rules\ViewOwnerActivityRule;
use yii\base\Component;
use yii\db\Query;

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

        $create_activity = $authManager->createPermission('create_activity');
        $create_activity->description = 'Создание события';

        $authManager->add($create_activity);

        $viewRule = new ViewOwnerActivityRule();
        $authManager->add($viewRule);

        $view_activity = $authManager->createPermission('view_activity');
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

        $id = \Yii::$app->auth->createDemoUser('admin@site.ru', '123456');
        $authManager->assign($admin, $id);

        $id = \Yii::$app->auth->createDemoUser('user@site.ru', '123456');
        $authManager->assign($user, $id);

    }

    public function getDbData()
    {
        $data = [];
        foreach(['auth_item', 'auth_item_child', 'auth_assignment', 'auth_rule'] as $table) {
            $data[$table] = (new Query())->select('*')
                ->from($table)->all();
        }
        return $data;
    }

    public function canCreateActivity():bool
    {
        return \Yii::$app->user->can('create_activity');
    }

    public function canViewActivity($activity):bool
    {
        if (\Yii::$app->user->can('editViewAllActivity')) {
            return true;
        }

        if (\Yii::$app->user->can('view_activity', [
            'activity' => $activity
        ])) {
            return true;
        }

        return false;
    }
}