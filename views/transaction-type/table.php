<?php

use yii\helpers\Html;

use kartik\form\ActiveForm;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\MultipleInput;
use yii\widgets\Pjax;

/**
* @var yii\web\View $this
* @var app\models\Item $models
*/

$this->title = Yii::t('models', 'Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Item'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Manage';
?>
<div class="giiant-crud item-update">

	<h1>
		<?= Yii::t('models', 'Items') ?>
	</h1>

	<hr />

	<?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

	<?php

	$form = ActiveForm::begin();

	echo TabularInput::widget([
		'models' => $models,
		'addButtonPosition'			=> TabularInput::POS_HEADER,
		'modelClass'				=> \app\models\Item::className(),
		'min'						=> 0,
		'allowEmptyList'			=> true,
		'attributeOptions' => [
			'enableAjaxValidation'      => true,
			'enableClientValidation'    => false,
			'validateOnChange'          => false,
			'validateOnSubmit'          => true,
			'validateOnBlur'            => false,

		],
		'columns' => [
			[
				'name'  => 'name',
				'title' => 'Name',
				'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,

			],
			[
				'name'  => 'description',
				'title' => 'Description',
				'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
			],
			[
				'name'  => 'price',
				'title' => 'Price',
				'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
			],
			[
				'name'  => 'credit',
				'title' => 'Credit',
				'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_CHECKBOX,
			],

		],
	]);


	echo Html::submitButton('Update', ['class' => 'btn btn-success']);    
	ActiveForm::end();

	\yii\widgets\Pjax::end(); 

	?>

</div>

