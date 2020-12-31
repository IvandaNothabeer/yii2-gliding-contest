<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Landout;

/**
* LandoutSearch represents the model behind the search form about `app\models\Landout`.
*/
class LandoutSearch extends Landout
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'pilot_id'], 'integer'],
            [['date','landed_at', 'departed_at', 'returned_at', 'address', 'trailer', 'plate', 'crew', 'crew_phone', 'notes', 'status'], 'safe'],
            [['lat', 'lng'], 'number'],
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
$query = Landout::find();

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
            'pilot_id' => $this->pilot_id,
            'date' => $this->date,
            'landed_at' => $this->landed_at,
            'departed_at' => $this->departed_at,
            'returned_at' => $this->returned_at,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'trailer', $this->trailer])
            ->andFilterWhere(['like', 'plate', $this->plate])
            ->andFilterWhere(['like', 'crew', $this->crew])
            ->andFilterWhere(['like', 'crew_phone', $this->crew_phone])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'status', $this->status]);

return $dataProvider;
}
}