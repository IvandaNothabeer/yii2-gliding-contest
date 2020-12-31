<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Towplane as TowplaneModel;

/**
* Towplane represents the model behind the search form about `\app\models\Towplane`.
*/
class Towplane extends TowplaneModel
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
[['id', 'contest_id'], 'integer'],
            [['rego', 'name'], 'safe'],
];
    }

    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function search($params)
    {
        $query = TowplaneModel::find();

        $dataProvider = new ActiveDataProvider([
'query' => $query,
]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'contest_id' => $this->contest_id,
        ]);

        $query->andFilterWhere(['like', 'rego', $this->rego])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
