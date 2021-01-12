<?php

use yii\db\Migration;

class m210112_053824_create_table_contests extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%contests}}',
            [
                'id' => $this->primaryKey(),
                'club_id' => $this->integer()->notNull(),
                'gnz_id' => $this->integer()->comment('GNZ Contest ID'),
                'name' => $this->string(80)->notNull()->comment('Contest Name'),
                'start' => $this->date()->notNull()->comment('Start Date'),
                'end' => $this->date()->notNull()->comment('End Date'),
                'igcfiles' => $this->string(12)->notNull()->comment('IGC Uploads Directory'),
            ],
            $tableOptions
        );

        $this->createIndex('club', '{{%contests}}', ['club_id']);
        $this->createIndex('name', '{{%contests}}', ['name'], true);

        $this->addForeignKey(
            'contests_ibfk_1',
            '{{%contests}}',
            ['club_id'],
            '{{%clubs}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('{{%contests}}');
    }
}
