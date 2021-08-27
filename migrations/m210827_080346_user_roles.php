<?php

use yii\db\Migration;

/**
 * Class m210827_080346_user_roles
 */
class m210827_080346_user_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'name',
            'description',
            'type'
        ];

        $rows = [
            ['Administrator', 'System Administrator', 1],
            ['Director', 'Contest Director', 1],
            ['Accounts', 'Manage User Accounts', 1],
            ['Operations', 'Manage Landouts and Retrieves', 1],
            ['ViewOnly', 'View Contest Data', 1],
        ];

        $this->batchInsert('{{%auth_item}}', $columns, $rows);

        $columns = [
            'parent',
            'child',
        ];

        $rows = [

            ['ViewOnly', 'AppClubView'],
            ['ViewOnly', 'AppContestView'],
            ['ViewOnly', 'AppLandoutView'],
            ['ViewOnly', 'AppLaunchView'],
            ['ViewOnly', 'AppRetrieveView'],
            ['ViewOnly', 'AppStatusView'],

            ['Administrator', 'AppClubFull'],
            ['Administrator', 'AppContestFull'],
            ['Administrator', 'AppDefaultTypeFull'],
            ['Administrator', 'AppLandoutFull'],
            ['Administrator', 'AppLaunchFull'],
            ['Administrator', 'AppPersonFull'],
            ['Administrator', 'AppPilotFull'],
            ['Administrator', 'AppRetrieveFull'],
            ['Administrator', 'AppStatusFull'],
            ['Administrator', 'AppTowplaneFull'],
            ['Administrator', 'AppTransactionFull'],
            ['Administrator', 'AppTransactionTypeFull'],
            ['Administrator', 'AppMasterTowplaneFull'],

            ['Director', 'AppClubView'],
            ['Director', 'AppContestFull'],
            ['Director', 'AppDefaultTypeFull'],
            ['Director', 'AppLandoutFull'],
            ['Director', 'AppLaunchFull'],
            ['Director', 'AppPersonFull'],
            ['Director', 'AppPilotFull'],
            ['Director', 'AppRetrieveFull'],
            ['Director', 'AppStatusFull'],
            ['Director', 'AppTowplaneFull'],
            ['Director', 'AppTransactionFull'],
            ['Director', 'AppTransactionTypeFull'],
            ['Director', 'AppMasterTowplaneFull'],
            ['Director', 'ViewOnly'],

            ['Accounts', 'AppDefaultTypeFull'],
            ['Accounts', 'AppPilotEdit'],
            ['Accounts', 'AppPilotView'],
            ['Accounts', 'AppTransactionFull'],
            ['Accounts', 'AppTransactionTypeFull'],
            ['Accounts', 'AppPersonFull'],
            ['Accounts', 'ViewOnly'],

            ['Operations', 'AppLaunchFull'],
            ['Operations', 'AppLandoutFull'],
            ['Operations', 'AppRetrieveFull'],
            ['Operations', 'AppStatusFull'],
            ['Operations', 'ViewOnly'],


        ];

        $this->batchInsert('{{%auth_item_child}}', $columns, $rows);

        $this->insert( '{{%auth_assignment}}', ['item_name'=>'Administrator', 'user_id'=>1]);
        
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210827_080346_user_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210827_080346_user_roles cannot be reverted.\n";

        return false;
    }
    */
}
