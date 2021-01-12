<?php

use yii\db\Migration;

class m210112_053843_create_table_landouts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%landouts}}',
            [
                'id' => $this->primaryKey()->comment('Land Out'),
                'pilot_id' => $this->integer()->notNull()->comment('Pilot'),
                'date' => $this->date()->notNull()->comment('Landout Date'),
                'landed_at' => $this->time()->notNull()->comment('Landout Time'),
                'departed_at' => $this->time()->comment('Crew Departed At'),
                'returned_at' => $this->time()->comment('Pilot Returned At'),
                'lat' => $this->decimal(12, 8)->comment('Latitude'),
                'lng' => $this->decimal(12, 8)->comment('Longitude'),
                'address' => $this->text()->comment('Address'),
                'trailer' => $this->string(80)->comment('Trailer Details'),
                'plate' => $this->string(10)->comment('Car Plate'),
                'crew' => $this->string(80)->comment('Crew Name'),
                'crew_phone' => $this->string(16)->comment('Crew Phone'),
                'notes' => $this->text()->comment('Notes'),
                'status' => $this->string()->comment('Status'),
            ],
            $tableOptions
        );

        $this->createIndex('pilot_id', '{{%landouts}}', ['pilot_id']);

        $this->addForeignKey(
            'landouts_ibfk_1',
            '{{%landouts}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropTable('{{%landouts}}');
    }
}
