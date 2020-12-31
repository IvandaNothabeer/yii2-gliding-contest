<?php

namespace app\models;

use Yii;
use \app\models\base\DefaultType as BaseDefaultType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "defaultTypes".
 */
class DefaultType extends BaseDefaultType
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
