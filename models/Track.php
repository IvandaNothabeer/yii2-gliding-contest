<?php

namespace app\models;

use Yii;
use yii\base\DynamicModel as Model;
use yii\helpers\ArrayHelper;


/**
* This is the model class for dynamic data "Track". from the GNZ Tracking API
*/
class Track extends Model
{


	public $attributes = [
		'id',
		'thetime',
		'lat',
		'lng',
		'hex',
		'alt',
		'speed',
		'course',
		'rego',
		'type',
		'vspeed',
		'altAvg',
		'found_alt',
		'alt_difference',
		'seconds_difference',
		'gl'
	];

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
}  
?>
