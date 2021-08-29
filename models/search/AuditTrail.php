<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use sammaye\audittrail\AuditTrail as AuditTrailModel;

/**
* AuditTrail represents the model behind the search form about `sammaye\audittrail\AuditTrail`.
*/
class AuditTrail extends AuditTrailModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['old_value', 'new_value', 'action', 'model', 'field', 'stamp', 'user_id', 'model_id'], 'safe'],
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
$query = AuditTrailModel::find();

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
            'stamp' => $this->stamp,
        ]);

        $query->andFilterWhere(['like', 'old_value', $this->old_value])
            ->andFilterWhere(['like', 'new_value', $this->new_value])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'model_id', $this->model_id]);

return $dataProvider;
}
}