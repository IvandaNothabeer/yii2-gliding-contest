<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Status as StatusModel;

/**
* StatusSearch represents the model behind the search form about `app\models\Status`.
*/
class Status extends StatusModel
{
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['id', 'pilot_id'], 'integer'],
			[['status', 'time'], 'safe'],
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
		$query = Status::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query->indexBy('id')->joinWith('pilot')->orderBy(['rego_short'=> 'ASC']),
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
			'time' => $this->time,
		]);

		$query->andFilterWhere(['like', 'status', $this->status]);

		return $dataProvider;
	}
}