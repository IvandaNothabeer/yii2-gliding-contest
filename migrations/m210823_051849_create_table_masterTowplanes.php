<?php

use yii\db\Migration;

class m210823_051849_create_table_masterTowplanes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%masterTowplanes}}',
            [
                'id' => $this->primaryKey(),
                'rego' => $this->string(4)->notNull()->comment('Towplane Registration'),
                'description' => $this->string(80)->notNull()->comment('Description'),
                'name' => $this->string(80)->notNull()->comment('Name'),
                'address1' => $this->string(80)->notNull()->comment('Address Line 1'),
                'address2' => $this->string(80)->comment('Address Line 2'),
                'address3' => $this->string(80)->comment('Address Line 3'),
                'postcode' => $this->string(8)->comment('Post Code'),
                'telephone' => $this->string(12)->comment('Phone'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%masterTowplanes}}');
    }
}
