<?php

use yii\db\Migration;

class m220203_215500_02_update_table_persons extends Migration
{
    public function up()
    {
        $this->addColumn('{{%persons}}', 'email', $this->string(100)->comment('E Mail')->after('telephone'));
    }

    public function down()
    {
        $this->dropColumn('{{%persons}}', 'email');
    }
}
