<?php

use yii\db\Migration;

/**
 * Class m210827_041945_DefaultType_insert
 */
class m210827_041945_DefaultType_insert extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns =[
            'name',
            'description',
            'price',
            'credit'
        ];

        $rows = [
            ['LAUNCH' , 'Contest Launch' , 65.00 , 'Debit'],
            ['RETRIEVE' , 'Aero Tow Retrieve' , 0.00 ,'Debit'],
            ['EFTPOS' , 'EFT Payment Received - Thankyou' , 0.00 , 'Credit'],
            ['CREDIT' , 'Credit Card Payment Received - Thankyou' , 0.00 , 'Credit'],
            ['DIRECT' , 'Direct Credit Payment Received - Thankyou' , 0.00 , 'Credit'],
            ['ENTRY', 'Contest Entry Fee' , 220.00 , 'Debit'],
            ['EARLY' , 'Contest Early Entry Discount', -40.00 , 'Credit'],
            ['BFAST' , 'Kitchen - Breakfast' , 10.00 , 'Debit'],
            ['LUNCH' , 'Kitchen - Lunch' , 10.00 , 'Debit'],
            ['DINNER' , 'Kitchen - Dinner' , 25.00 , 'Debit'],
            ['CAMP' , 'Camp Site' , 10.00 , 'Debit'],
            ['BUNK' , 'Bunk House', 15.00 , 'Debit'],
            ['INTERNET' , 'Internet Access' , 10.00 , 'Debit']
        ];

        $this->batchInsert('{{%defaultTypes}}',$columns, $rows);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210827_041945_DefaultType_insert cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210827_041945_DefaultType_insert cannot be reverted.\n";

        return false;
    }
    */
}
