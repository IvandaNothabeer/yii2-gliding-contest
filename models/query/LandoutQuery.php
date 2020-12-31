<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Landout]].
 *
 * @see \app\models\Landout
 */
class LandoutQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Landout[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Landout|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
