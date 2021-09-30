<?php

namespace app\models;

use Yii;
use \app\models\base\Sms as BaseSms;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "received_sms".
 */
class Sms extends BaseSms
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
