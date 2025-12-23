<?php

use yii\db\Migration;

class m251223_002204_create_project_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'owner_user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-project-owner_user_id}}',
            '{{%project}}',
            'owner_user_id'
        );

        $this->addForeignKey(
            '{{%fk-project-owner_user_id}}',
            '{{%project}}',
            'owner_user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-project-owner_user_id}}', '{{%project}}');
        $this->dropIndex('{{%idx-project-owner_user_id}}', '{{%project}}');
        $this->dropTable('{{%project}}');
    }
}