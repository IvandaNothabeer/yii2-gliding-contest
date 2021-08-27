<?php

use yii\db\Migration;

class m210826_061137_04_update_table_towplanes extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%towplanes}}', 'rego', $this->string(4)->notNull()->comment('Towplane Registration'));
    }

    public function down()
    {
        $this->alterColumn('{{%towplanes}}', 'rego', $this->string(3)->notNull()->comment('Towplane Registration'));
    }
}
