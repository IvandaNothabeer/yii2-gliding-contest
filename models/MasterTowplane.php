<?php

namespace app\models;

use Yii;
use \app\models\base\MasterTowplane as BaseMasterTowplane;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "masterTowplanes".
 */
class MasterTowplane extends BaseMasterTowplane
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rego' => 'Towplane Registration',
            'description' => 'Description',
            'name' => 'Owner Name',
            'address1' => 'Address Line 1',
            'address2' => 'Address Line 2',
            'address3' => 'Address Line 3',
            'postcode' => 'Post Code',
            'telephone' => 'Phone',
        ];
    }
}
