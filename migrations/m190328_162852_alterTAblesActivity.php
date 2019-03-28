<?php

use yii\db\Migration;

/**
 * Class m190328_162852_alterTAblesActivity
 */
class m190328_162852_alterTAblesActivity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('activity','user_id',$this->integer()->notNull());

        $this->addForeignKey('activity_userFK','activity','user_id',
            'users','id','CASCADE','CASCADE');

        $this->createIndex('usersEmailInd','users','email',true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('activity_userFK','activity');
        $this->dropColumn('activity','user_id');
        $this->dropIndex('usersEmailInd','users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_162852_alterTAblesActivity cannot be reverted.\n";

        return false;
    }
    */
}
