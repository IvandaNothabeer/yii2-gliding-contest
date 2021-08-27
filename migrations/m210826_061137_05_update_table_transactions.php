<?php

use yii\db\Migration;

class m210826_061137_05_update_table_transactions extends Migration
{
    public function up()
    {
        $this->dropForeignKey('transactions_ibfk_1', '{{%transactions}}');
        $this->dropIndex('pilot_id', '{{%transactions}}');       
        $this->dropColumn('{{%transactions}}', 'pilot_id');

        $this->addColumn('{{%transactions}}', 'person_id', $this->integer()->notNull()->comment('Pilot')->after('id'));

        $this->alterColumn('{{%transactions}}', 'item_price', $this->decimal(8, 2)->notNull()->comment('Item Price'));
        $this->alterColumn('{{%transactions}}', 'amount', $this->decimal(8, 2)->notNull()->comment('Total Price'));

        $this->addForeignKey(
            'transactions_ibfk_1',
            '{{%transactions}}',
            ['person_id'],
            '{{%persons}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );


    }

    public function down()
    {
        $this->createIndex('pilot_id', '{{%transactions}}', ['pilot_id']);

        $this->dropForeignKey('transactions_ibfk_1', '{{%transactions}}');

        $this->addForeignKey(
            'transactions_ibfk_1',
            '{{%transactions}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->alterColumn('{{%transactions}}', 'item_price', $this->decimal(8, 2)->notNull()->defaultValue('0')->comment('Item Price')->after('quantity'));
        $this->alterColumn('{{%transactions}}', 'amount', $this->decimal(8, 2)->comment('Total Price'));

        $this->dropColumn('{{%transactions}}', 'person_id');

        $this->addColumn('{{%transactions}}', 'pilot_id', $this->integer()->notNull()->comment('Pilot'));
    }
}
