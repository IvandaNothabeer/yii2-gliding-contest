<?php

use yii\db\Migration;

class m210826_061137_02_update_table_persons extends Migration
{
    public function up()
    {
        $this->addColumn('{{%persons}}', 'address1', $this->string(80)->comment('Address Line 1')->after('name'));
        $this->addColumn('{{%persons}}', 'address2', $this->string(80)->comment('Address Line 2')->after('address1'));
        $this->addColumn('{{%persons}}', 'address3', $this->string(80)->comment('Address Line 3')->after('address2'));
        $this->addColumn('{{%persons}}', 'postcode', $this->string(12)->comment('Postcode')->after('address3'));

        $this->alterColumn('{{%persons}}', 'name', $this->string(80)->notNull()->comment('Name'));
        $this->alterColumn('{{%persons}}', 'role', $this->string()->comment('Contest Role'));
        $this->alterColumn('{{%persons}}', 'telephone', $this->text()->comment('Mobile Number'));
    }

    public function down()
    {
        $this->alterColumn('{{%persons}}', 'name', $this->string(80)->notNull()->comment('Persons Name'));
        $this->alterColumn('{{%persons}}', 'role', $this->string(40)->defaultValue('Volunteer')->comment('Contest Role'));
        $this->alterColumn('{{%persons}}', 'telephone', $this->text()->notNull()->comment('Mobile Contact Number for SMS'));

        $this->dropColumn('{{%persons}}', 'address1');
        $this->dropColumn('{{%persons}}', 'address2');
        $this->dropColumn('{{%persons}}', 'address3');
        $this->dropColumn('{{%persons}}', 'postcode');
    }
}
