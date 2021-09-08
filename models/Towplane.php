<?php

namespace app\models;

use Yii;
use \app\models\base\Towplane as BaseTowplane;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "towplanes".
 */
class Towplane extends BaseTowplane
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
            'contest_id' => 'Contest',
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

    public static function find()
	{
		if (\Yii::$app->request->isConsoleRequest)
			return parent::find();

		if (\Yii::$app->user->isGuest){
			$contest = 0;	
		}
		else{
			$contest = \yii::$app->user->identity->profile->contest_id;
		}

		return parent::find()->andWhere(['contest_id' => $contest]);

	}

	public static function findEvery()
	{
		return parent::find();
	}
}
