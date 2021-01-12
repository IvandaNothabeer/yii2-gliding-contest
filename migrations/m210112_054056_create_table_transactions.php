<?php

use yii\db\Migration;

class m210112_054056_create_table_transactions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%transactions}}',
            [
                'id' => $this->primaryKey(),
                'pilot_id' => $this->integer()->notNull()->comment('Pilot'),
                'type_id' => $this->integer()->notNull()->comment('Transaction Type'),
                'details' => $this->string(80)->comment('Details'),
                'amount' => $this->decimal(8, 2)->notNull()->comment('Amount'),
                'date' => $this->date()->notNull()->comment('Date'),
            ],
            $tableOptions
        );

        $this->createIndex('type_id', '{{%transactions}}', ['type_id']);
        $this->createIndex('pilot_id', '{{%transactions}}', ['pilot_id']);

        $this->addForeignKey(
            'transactions_ibfk_1',
            '{{%transactions}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'transactions_ibfk_2',
            '{{%transactions}}',
            ['type_id'],
            '{{%transactionTypes}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('{{%transactions}}');
    }
}
