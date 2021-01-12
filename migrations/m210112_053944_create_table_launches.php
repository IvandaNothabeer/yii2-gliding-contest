<?php

use yii\db\Migration;

class m210112_053944_create_table_launches extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%launches}}',
            [
                'id' => $this->primaryKey(),
                'towplane_id' => $this->integer()->notNull()->comment('Towplane'),
                'pilot_id' => $this->integer()->notNull()->comment('Glider'),
                'date' => $this->date()->notNull()->comment('Launch Date'),
                'transaction_id' => $this->integer()->comment('Account Transaction ID'),
            ],
            $tableOptions
        );

        $this->createIndex('pilot_id', '{{%launches}}', ['pilot_id']);
        $this->createIndex('towplane_id', '{{%launches}}', ['towplane_id']);
        $this->createIndex('transaction_id', '{{%launches}}', ['transaction_id']);

        $this->addForeignKey(
            'launches_ibfk_1',
            '{{%launches}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'launches_ibfk_2',
            '{{%launches}}',
            ['towplane_id'],
            '{{%towplanes}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
        $this->addForeignKey(
            'launches_ibfk_3',
            '{{%launches}}',
            ['transaction_id'],
            '{{%transactions}}',
            ['id'],
            'SET NULL',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%launches}}');
    }
}
