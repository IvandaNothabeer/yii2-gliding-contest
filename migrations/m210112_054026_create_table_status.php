<?php

use yii\db\Migration;

class m210112_054026_create_table_status extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%status}}',
            [
                'id' => $this->primaryKey()->comment('ID'),
                'pilot_id' => $this->integer()->notNull()->comment('Pilot'),
                'status' => $this->string()->comment('Status'),
                'date' => $this->date()->comment('Date'),
                'time' => $this->time()->comment('Time'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%status}}');
    }
}
