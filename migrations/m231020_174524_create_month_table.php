<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%month}}`.
 */
class m231020_174524_create_month_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('months', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(10)->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->batchInsert('months', ['name'], [
            ['Январь'],
            ['Февраль'],
            ['Август'],
            ['Сентябрь'],
            ['Октябрь'],
            ['Ноябрь'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('months');
    }
}
