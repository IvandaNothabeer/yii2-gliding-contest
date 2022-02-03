<?php

use yii\db\Migration;

class m220204_085500_01_update_table_clubs extends Migration
{
    public function up()
    {
        $this->addColumn('{{%clubs}}', 'email', $this->string(100)->comment('E Mail')->after('telephone'));
        $this->addColumn('{{%clubs}}', 'bankname', $this->string(40)->comment('Bank Name')->after('email'));
        $this->addColumn('{{%clubs}}', 'bankno', $this->string(16)->comment('Account Number')->after('bankname'));
        $this->addColumn('{{%clubs}}', 'gstno', $this->string(16)->comment('GST Number')->after('bankno'));
    }

    public function down()
    {
        $this->dropColumn('{{%clubs}}', 'email');
        $this->dropColumn('{{%clubs}}', 'bankname');
        $this->dropColumn('{{%clubs}}', 'bankno');
        $this->dropColumn('{{%clubs}}', 'gstno');    }
}
