<?php

namespace app\models;

use Yii;
use \app\models\base\Landout as BaseLandout;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "landouts".
 */
class Landout extends BaseLandout
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
}
