<?php

use yii\db\Migration;

class m210112_054052_create_table_transactionTypes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%transactionTypes}}',
            [
                'id' => $this->primaryKey(),
                'contest_id' => $this->integer()->notNull()->comment('Contest'),
                'name' => $this->string(12)->notNull()->comment('Short Name'),
                'description' => $this->string(80)->notNull()->comment('Item Description'),
                'price' => $this->decimal(8, 2)->comment('Usual Price'),
                'credit' => $this->string()->notNull()->comment('Debit or Credit Item'),
            ],
            $tableOptions
        );

        $this->createIndex('contest_id', '{{%transactionTypes}}', ['contest_id']);

        $this->addForeignKey(
            'transactiontypes_ibfk_1',
            '{{%transactionTypes}}',
            ['contest_id'],
            '{{%contests}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%transactionTypes}}');
    }
}
