<?php

use yii\db\Migration;

/**
 * Class m210826_064250_update_table_profile
 */
class m210826_064250_update_table_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%profile}}', 'club_id', $this->integer(11)->notNull()->defaultValue(0));
        $this->addColumn('{{%profile}}', 'contest_id', $this->integer(11)->notNull()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210826_064250_update_table_profile cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210826_064250_update_table_profile cannot be reverted.\n";

        return false;
    }
    */
}
