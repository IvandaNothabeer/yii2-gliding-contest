<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction as TransactionModel;

/**
* Transaction represents the model behind the search form about `\app\models\Transaction`.
*/
class Transaction extends TransactionModel
{
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['id', 'person_id', 'type_id', 'quantity'], 'integer'],
			[['details', 'date'], 'safe'],
			[['amount', 'item_price'], 'number'],
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
		$query = TransactionModel::find();

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
			'type_id' => $this->type_id,
			'amount' => $this->amount,
			'date' => $this->date,
		]);

		$query->andFilterWhere(['like', 'details', $this->details]);

		return $dataProvider;
	}
}