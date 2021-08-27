<?php

use yii\db\Migration;

class m210826_061137_03_update_table_pilots extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%pilots}}', 'name');
        $this->dropColumn('{{%pilots}}', 'address1');
        $this->dropColumn('{{%pilots}}', 'address2');
        $this->dropColumn('{{%pilots}}', 'address3');
        $this->dropColumn('{{%pilots}}', 'postcode');
        $this->dropColumn('{{%pilots}}', 'telephone');

        $this->addColumn('{{%pilots}}', 'person_id', $this->integer()->notNull()->comment('Pilot ID')->after('id'));

        $this->addForeignKey(
            'pilots_ibfk_2',
            '{{%pilots}}',
            ['person_id'],
            '{{%persons}}',
            ['id'],
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('pilots_ibfk_2', '{{%pilots}}');

        $this->dropColumn('{{%pilots}}', 'person_id');

        $this->addColumn('{{%pilots}}', 'name', $this->string(80)->notNull()->comment('Name'));
        $this->addColumn('{{%pilots}}', 'address1', $this->string(80)->notNull()->comment('Address Line 1'));
        $this->addColumn('{{%pilots}}', 'address2', $this->string(80)->comment('Address Line 2'));
        $this->addColumn('{{%pilots}}', 'address3', $this->string(80)->comment('Address Line 3'));
        $this->addColumn('{{%pilots}}', 'postcode', $this->string(12)->comment('Post Code'));
        $this->addColumn('{{%pilots}}', 'telephone', $this->string(16)->comment('Telephone'));
    }
}
