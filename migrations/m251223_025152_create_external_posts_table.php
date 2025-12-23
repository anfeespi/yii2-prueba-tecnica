<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%external_posts}}`.
 */
class m251223_025152_create_external_posts_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%external_posts}}', [
            'id' => $this->primaryKey(),
            
            'external_id' => $this->integer()->notNull(), 
            
            
            'user_id' => $this->integer(),
            'title' => $this->string(),
            'body' => $this->text(),
            
           
            'payload' => $this->text(),
            'hash' => $this->string(),
            
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx-external_posts-external_id}}',
            '{{%external_posts}}',
            'external_id',
            true
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%external_posts}}');
    }
}
