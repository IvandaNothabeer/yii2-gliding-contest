<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DefaultType as DefaultTypeModel;

/**
* DefaultType represents the model behind the search form about `\app\models\DefaultType`.
*/
class DefaultType extends DefaultTypeModel
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
[['id', 'credit'], 'integer'],
            [['name', 'description'], 'safe'],
            [['price'], 'number'],
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
        $query = DefaultTypeModel::find();

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
            'price' => $this->price,
            'credit' => $this->credit,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
