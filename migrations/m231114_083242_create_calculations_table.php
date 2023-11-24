<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calculations}}`.
 */
class m231114_083242_create_calculations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calculations}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'user' => $this->string(255)->notNull(),
            'month' => $this->string(10)->notNull(),
            'type' => $this->string(10)->notNull(),
            'tonnage' => $this->tinyInteger(3)->notNull(),
            'result' => $this->tinyInteger(3)->unsigned()->notNull(),
            'table_data' => $this->text()->notNull(),
            'all_months' => $this->text()->notNull(),
            'all_tonnages' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calculations}}');
    }
}
