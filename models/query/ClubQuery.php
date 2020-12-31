<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Club]].
 *
 * @see \app\models\Club
 */
class ClubQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Club[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Club|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
