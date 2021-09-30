<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sms as SmsModel;
use Codeception\Lib\Console\Message;

/**
* Sms represents the model behind the search form about `\app\models\Sms`.
*/
class Sms extends SmsModel
{
/**
* @inheritdoc
*/
public function rules()
{
return [
    [['from', 'sender_id'], 'integer'],
    [['sent', 'received'], 'safe'],
    [['message'], 'string'],
    [['sender'], 'string', 'max' => 80]
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
$query = SmsModel::find();

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
            'from' => $this->from,
            'sender_id' => $this->sender_id,
            'sent' => $this->sent,
            'received' => $this->received,
            'sender' => $this->sender,
]);

$query->andFilterWhere(['like', 'message', $this->message]);


return $dataProvider;
}
}