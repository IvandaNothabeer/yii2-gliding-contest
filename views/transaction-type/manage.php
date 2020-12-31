<?php

use yii\helpers\Html;

use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
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
	echo TabularForm::widget([
		'dataProvider'=>$dataProvider,
		'form'=>$form,
		'attributes'=>[
			'name'=>['type'=>TabularForm::INPUT_STATIC],
			'description'=>['type'=>TabularForm::INPUT_TEXT],
			'price'=>['type'=>TabularForm::INPUT_TEXT],
			'credit'=>['type'=>TabularForm::INPUT_CHECKBOX],
		],
		'gridSettings'=>[
			'condensed'=>true,
			'panel'=>[
				'before' => false,
				//'type' => GridView::TYPE_PRIMARY,
				'after'=> Html::a('<i class="fas fa-plus"></i> Add New', '#', ['class'=>'btn btn-success']) . ' ' . 
				Html::a('<i class="fas fa-times"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
				Html::submitButton('<i class="fas fa-save"></i> Save',['class'=>'btn btn-primary'])
			],
		]
	]);

	ActiveForm::end();
	
    \yii\widgets\Pjax::end(); 
    
	?>
	
</div>

