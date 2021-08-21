<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pilot as PilotModel;

/**
* Pilot represents the model behind the search form about `\app\models\Pilot`.
*/
class Pilot extends PilotModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'person_id', 'contest_id', 'gnz_id'], 'integer'],
            [['rego', 'rego_short', 'entry_date', 'trailer', 'plate', 'crew', 'crew_phone'], 'safe'],
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
$query = PilotModel::find();

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
            'person_id' => $this->person_id,
            'contest_id' => $this->contest_id,
            'gnz_id' => $this->gnz_id,
            'entry_date' => $this->entry_date,
        ]);

        $query->andFilterWhere(['like', 'rego', $this->rego])
            ->andFilterWhere(['like', 'rego_short', $this->rego_short])
            ->andFilterWhere(['like', 'trailer', $this->trailer])
            ->andFilterWhere(['like', 'plate', $this->plate])
            ->andFilterWhere(['like', 'crew', $this->crew])
            ->andFilterWhere(['like', 'crew_phone', $this->crew_phone]);

return $dataProvider;
}
}