<?php

use yii\db\Migration;

class m231118_220550_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [

            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        // ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
