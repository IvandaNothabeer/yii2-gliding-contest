<?php

use yii\db\Migration;

class m210112_053817_create_table_clubs extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%clubs}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(80)->notNull()->comment('Club Name'),
                'address1' => $this->string(80)->notNull()->comment('Address Line 1'),
                'address2' => $this->string(80)->comment('Address Line 2'),
                'address3' => $this->string(80)->comment('Address Line 3'),
                'postcode' => $this->string(8)->comment('Post Code'),
                'telephone' => $this->string(16)->comment('Telephone'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%clubs}}');
    }
}
