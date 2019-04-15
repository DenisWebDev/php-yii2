<?php

use app\modules\auth\components\AuthComponent;
use yii\db\Migration;

/**
 * Class m190414_201031_add_demo_users
 */
class m190414_201031_add_demo_users extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function safeUp()
    {
        $user = $this->getAuthComponent()->addNewUser('admin@site.ru', '123456');
        $this->getRbacComponent()->assignAdminRole($user->id);

        $user = $this->getAuthComponent()->addNewUser('user@site.ru', '123456');
        $this->getRbacComponent()->assignUserRole($user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('user');
    }

    /**
     * @return AuthComponent
     */
    private function getAuthComponent()
    {
        return \Yii::$app->auth;
    }

    /**
     * @return \app\components\RbacComponent
     */
    private function getRbacComponent()
    {
        return \Yii::$app->rbac;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190414_201031_add_demo_users cannot be reverted.\n";

        return false;
    }
    */
}
