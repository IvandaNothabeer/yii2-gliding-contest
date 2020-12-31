<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Retrieve]].
 *
 * @see \app\models\Retrieve
 */
class RetrieveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Retrieve[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Retrieve|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
