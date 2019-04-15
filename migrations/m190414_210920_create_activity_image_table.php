<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity_image`.
 */
class m190414_210920_create_activity_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('activity_image', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ], $table_options);

        $this->addForeignKey('fk_activity_activity_image',
            'activity_image', 'activity_id',
            'activity', 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_activity_activity_image', 'activity_image');
        $this->dropTable('activity_image');
    }
}
