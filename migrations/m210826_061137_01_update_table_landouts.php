<?php

use yii\db\Migration;

class m210826_061137_01_update_table_landouts extends Migration
{
    public function up()
    {
        $this->addColumn('{{%landouts}}', 'rego_short', $this->string(2)->notNull()->comment('Glider Registration')->after('pilot_id'));
        $this->addColumn('{{%landouts}}', 'name', $this->string(80)->notNull()->comment('Pilot Name')->after('rego_short'));
        $this->addColumn('{{%landouts}}', 'telephone', $this->string(16)->notNull()->comment('Pilot Phone')->after('name'));

        $this->alterColumn('{{%landouts}}', 'pilot_id', $this->integer()->comment('Pilot'));

        $this->dropForeignKey('landouts_ibfk_1', '{{%landouts}}');

        $this->addForeignKey(
            'landouts_ibfk_1',
            '{{%landouts}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        $this->dropForeignKey('landouts_ibfk_1', '{{%landouts}}');

        $this->addForeignKey(
            'landouts_ibfk_1',
            '{{%landouts}}',
            ['pilot_id'],
            '{{%pilots}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );

        $this->alterColumn('{{%landouts}}', 'pilot_id', $this->integer()->notNull()->comment('Pilot'));

        $this->dropColumn('{{%landouts}}', 'rego_short');
        $this->dropColumn('{{%landouts}}', 'name');
        $this->dropColumn('{{%landouts}}', 'telephone');
    }
}
