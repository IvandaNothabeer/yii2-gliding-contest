<?php

use yii\db\Migration;

class m210112_053956_create_table_persons extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%persons}}',
            [
                'id' => $this->primaryKey()->comment('ID'),
                'contest_id' => $this->integer()->notNull()->comment('Contest Name'),
                'name' => $this->string(80)->notNull()->comment('Persons Name'),
                'role' => $this->string(40)->defaultValue('Volunteer')->comment('Contest Role'),
                'telephone' => $this->text()->notNull()->comment('Mobile Contact Number for SMS'),
            ],
            $tableOptions
        );

        $this->createIndex('contest_id', '{{%persons}}', ['contest_id']);

        $this->addForeignKey(
            'persons_ibfk_1',
            '{{%persons}}',
            ['contest_id'],
            '{{%contests}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('{{%persons}}');
    }
}
