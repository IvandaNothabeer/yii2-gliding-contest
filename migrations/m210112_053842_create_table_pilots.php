<?php

use yii\db\Migration;

class m210112_053842_create_table_pilots extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%pilots}}',
            [
                'id' => $this->primaryKey(),
                'contest_id' => $this->integer()->notNull(),
                'gnz_id' => $this->integer()->comment('GNZ Pilot ID'),
                'name' => $this->string(80)->notNull()->comment('Name'),
                'address1' => $this->string(80)->notNull()->comment('Address Line 1'),
                'address2' => $this->string(80)->comment('Address Line 2'),
                'address3' => $this->string(80)->comment('Address Line 3'),
                'postcode' => $this->string(12)->comment('Post Code'),
                'telephone' => $this->string(16)->comment('Telephone'),
                'rego' => $this->string(6)->comment('Glider Registration'),
                'rego_short' => $this->string(2)->comment('Glider Contest ID'),
                'entry_date' => $this->dateTime()->comment('Entry Date'),
                'trailer' => $this->string(80)->comment('Car & Trailer'),
                'plate' => $this->string(20)->comment('Car Plate'),
                'crew' => $this->string(80)->comment('Crew Name'),
                'crew_phone' => $this->string(16)->comment('Crew Phone'),
            ],
            $tableOptions
        );

        $this->createIndex('contest_id', '{{%pilots}}', ['contest_id']);

        $this->addForeignKey(
            'pilots_ibfk_1',
            '{{%pilots}}',
            ['contest_id'],
            '{{%contests}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('{{%pilots}}');
    }
}
