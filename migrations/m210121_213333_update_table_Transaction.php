<?php

use yii\db\Migration;

/**
 * Class m210121_213333_update_table_Transaction
 */
class m210121_213333_update_table_Transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    	$this->addColumn('transactions', 'quantity', $this->integer()->after('details')->notNull()->defaultValue(1)->comment('Quantity'));
    	$this->addColumn('transactions', 'item_price', $this->decimal(8,2)->after('quantity')->notNull()->defaultValue(0)->comment('Item Price'));
    	$this->alterColumn('transactions', 'amount', $this->decimal(8,2)->comment('Total Price'));
    	
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210121_213333_update_table_Transaction cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210121_213333_update_table_Transaction cannot be reverted.\n";

        return false;
    }
    */
}
