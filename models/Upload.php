<?php

namespace app\models;

use Yii;
use yii\base\DynamicModel as Model;
use yii\helpers\ArrayHelper;


/**
* This is the model class for dynamic data "Track". from the GNZ Tracking API
*/
class Upload extends Model
{

	public $date;
	public $contest_id;
	public $pilot_id;
	public $rego;
	public $file;


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
				[['file'], 'file', 'skipOnEmpty' => false],
				[['file'], 'file', 'extensions' => 'igc', 'checkExtensionByMimeType' => false],
				[['date', 'contest_id', 'pilot_id', 'rego'], 'required'],
				[['date', 'contest_id', 'pilot_id', 'file', 'rego'], 'safe' ],
				
			]
		);
	}
}  
?>
