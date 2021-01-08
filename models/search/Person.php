<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Person as PersonModel;

/**
* Person represents the model behind the search form about `\app\models\Person`.
*/
class Person extends PersonModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['name', 'role', 'telephone'], 'safe'],
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
$query = PersonModel::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'telephone', $this->telephone]);

return $dataProvider;
}
}