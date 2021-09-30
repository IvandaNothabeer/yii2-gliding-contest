<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Sms]].
 *
 * @see \app\models\Sms
 */
class SmsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Sms[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Sms|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
