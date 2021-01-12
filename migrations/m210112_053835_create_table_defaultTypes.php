<?php

use yii\db\Migration;

class m210112_053835_create_table_defaultTypes extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%defaultTypes}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(12)->notNull()->comment('Short Name'),
                'description' => $this->string(80)->notNull()->comment('Item Description'),
                'price' => $this->decimal(8, 2)->comment('Usual Price'),
                'credit' => $this->string()->notNull()->comment('Debit or Credit Item'),
            ],
            $tableOptions
        );

        $this->createIndex('id', '{{%defaultTypes}}', ['id'], true);
    }

    public function down()
    {
        $this->dropTable('{{%defaultTypes}}');
    }
}
