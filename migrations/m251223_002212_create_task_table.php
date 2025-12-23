<?php

use yii\db\Migration;

class m251223_002212_create_task_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'status' => "ENUM('todo', 'doing', 'done') NOT NULL DEFAULT 'todo'",
            'priority' => $this->integer()->notNull()->defaultValue(1)->comment('1 to 5'),
            'due_date' => $this->dateTime()->null(), // Puede ser null
            'created_by' => $this->integer()->notNull(),
            'assigned_to' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-task-project_id}}', '{{%task}}', 'project_id');
        $this->addForeignKey(
            '{{%fk-task-project_id}}',
            '{{%task}}', 'project_id',
            '{{%project}}', 'id',
            'CASCADE'
        );

        $this->createIndex('{{%idx-task-created_by}}', '{{%task}}', 'created_by');
        $this->addForeignKey(
            '{{%fk-task-created_by}}',
            '{{%task}}', 'created_by',
            '{{%user}}', 'id',
            'CASCADE'
        );

        $this->createIndex('{{%idx-task-assigned_to}}', '{{%task}}', 'assigned_to');
        $this->addForeignKey(
            '{{%fk-task-assigned_to}}',
            '{{%task}}', 'assigned_to',
            '{{%user}}', 'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-task-project_id}}', '{{%task}}');
        $this->dropForeignKey('{{%fk-task-created_by}}', '{{%task}}');
        $this->dropForeignKey('{{%fk-task-assigned_to}}', '{{%task}}');
        
        $this->dropIndex('{{%idx-task-project_id}}', '{{%task}}');
        $this->dropIndex('{{%idx-task-created_by}}', '{{%task}}');
        $this->dropIndex('{{%idx-task-assigned_to}}', '{{%task}}');

        $this->dropTable('{{%task}}');
    }
}
