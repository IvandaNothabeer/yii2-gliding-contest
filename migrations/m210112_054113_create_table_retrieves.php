<?php

use yii\db\Migration;

class m210112_054113_create_table_retrieves extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%retrieves}}',
            [
                'id' => $this->primaryKey(),
                'towplane_id' => $this->integer()->notNull()->comment('Towplane'),
                'pilot_id' => $this->integer()->notNull()->comment('Glider'),
                'date' => $this->date()->notNull()->comment('Retrieve Date'),
                'duration' => $this->integer()->notNull()->comment('Retrive Duration'),
                'price' => $this->decimal(6, 2)->notNull()->comment('Retrieve Cost'),
                'transaction_id' => $this->integer()->comment('Transaction'),
            ],
            $tableOptions
        );

        $this->createIndex('pilot_id', '{{%retrieves}}', ['pilot_id']);
        $this->createIndex('towplane_id', '{{%retrieves}}', ['towplane_id']);
        $this->createIndex('transaction_id', '{{%retrieves}}', ['transaction_id']);

        $this->addForeignKey(
            'retrieves_ibfk_1',
            '{{%retrieves}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'retrieves_ibfk_2',
            '{{%retrieves}}',
            ['towplane_id'],
            '{{%towplanes}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'retrieves_ibfk_3',
            '{{%retrieves}}',
            ['transaction_id'],
            '{{%transactions}}',
            ['id'],
            'SET NULL',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%retrieves}}');
    }
}
