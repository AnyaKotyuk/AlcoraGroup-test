<?php

use yii\db\Migration;

/**
 * Handles the creation of table `test_form`.
 * Here user
 */
class m180226_091959_create_test_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull(),
            'age' => $this->integer()->notNull(),
            'height' => $this->string(20)->notNull(),
            'weight' => $this->integer()->notNull(),
            'city' => $this->string(100)->notNull(),
            'technique' => $this->string(20)->notNull(),
            'english' => $this->string(30)->notNull(),
            'images' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('test');
    }
}
