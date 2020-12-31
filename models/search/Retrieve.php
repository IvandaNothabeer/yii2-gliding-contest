<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Retrieve as RetrieveModel;

/**
* Retrieve represents the model behind the search form about `\app\models\Retrieve`.
*/
class Retrieve extends RetrieveModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'towplane_id', 'pilot_id'], 'integer'],
            [['date'], 'safe'],
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
$query = RetrieveModel::find();

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
            'towplane_id' => $this->towplane_id,
            'pilot_id' => $this->pilot_id,
            'date' => $this->date,
        ]);

return $dataProvider;
}
}