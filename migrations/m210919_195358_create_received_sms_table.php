<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%received_sms}}`.
 */
class m210919_195358_create_received_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%received_sms}}', [
            'id' => $this->primaryKey(11),
            'from' => $this->bigInteger(20)->notNull()->comment('From'),
            'sent' => $this->dateTime()->comment('Sent At'),
            'received' => $this->dateTime()->comment('Received At'),
            'sender_id' => $this->bigInteger()->defaultValue(0)->comment('Sender ID'),
            'sender' => $this->string(80)->comment('Sender Name'),
            'message' =>$this->text()->comment('Message')
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%received_sms}}');
    }
}
