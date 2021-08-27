<?php

use yii\db\Migration;

/**
 * Class m210827_063113_User_insert
 */
class m210827_063113_User_insert extends Migration
{
    // @codingStandardsIgnoreEnd

    /**
     * Table name
     *
     * @var string
     */
    private $_user = "{{%user}}";

    /**
     * @var string
     */
    private $_profile = "{{%profile}}";

    /**
     * Runs for the migate/up command
     *
     * @return null
     */
    public function safeUp()
    {
        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $auth_key = Yii::$app->security->generateRandomString();
        $table = $this->_user;

        $sql = <<<SQL
        INSERT INTO {$table}
        (`username`, `email`,`password_hash`, `auth_key`, `created_at`, `updated_at`)
        VALUES
        ('admin', 'admin@localhost.com',  '$password_hash', '$auth_key', {$time}, {$time})
SQL;
        Yii::$app->db->createCommand($sql)->execute();

        $id = Yii::$app->db->getLastInsertID();

        //add profile entry for admin
        $this->insert(
            $this->_profile,
            [
                'user_id' => $id,
                'name' => 'Administrator',
            ]
        );

    }

    /**
     * Runs for the migate/down command
     *
     * @return null
     */
    public function safeDown()
    {
        $table = $this->_user;
        $sql = <<<SQL
        SELECT id from {$table}
        where username='admin'
SQL;
        $id = Yii::$app->db->createCommand($sql)->execute();
        $this->delete($this->_user, ['username' => 'admin']);
        $this->delete($this->_profile, ['user_id' => $id]);
    }

}
