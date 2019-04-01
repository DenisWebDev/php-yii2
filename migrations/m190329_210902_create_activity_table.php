<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity`.
 */
class m190329_210902_create_activity_table extends Migration
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

        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'date_start' => $this->dateTime()->notNull(),
            'date_end' => $this->dateTime(),
            'repeat_type_id' => $this->integer()->notNull(),
            'is_blocked' => $this->boolean()->notNull()->defaultValue(0),
            'use_notification' => $this->boolean()->notNull()->defaultValue(0),
            'email' => $this->string(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $this->addForeignKey('fk_user_activity',
            'activity', 'user_id',
            'user', 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_activity', 'activity');
        $this->dropTable('activity');
    }
}
