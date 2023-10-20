<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 */
class m231020_175037_create_prices_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey()->unsigned(),
            'price' => $this->tinyInteger(3)->unsigned()->notNull(),
            'month_id' => $this->integer(11)->unsigned()->notNull(),
            'tonnage_id' => $this->integer(11)->unsigned()->notNull(),
            'raw_type_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx-prices-unique', 'prices', ['month_id', 'tonnage_id', 'raw_type_id'], true);

        $this->addForeignKey('fk-prices-month_id', 'prices', 'month_id', 'months', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk-prices-tonnage_id', 'prices', 'tonnage_id', 'tonnages', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('fk-prices-raw_type_id', 'prices', 'raw_type_id', 'raw_types', 'id', 'CASCADE', 'NO ACTION');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-prices-raw_type_id', 'prices');
        $this->dropForeignKey('fk-prices-tonnage_id', 'prices');
        $this->dropForeignKey('fk-prices-month_id', 'prices');

        $this->dropTable('prices');
    }
}
