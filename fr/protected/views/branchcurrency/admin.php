<?php
/* @var $this BranchcurrencyController */
/* @var $model Branchcurrency */

$this->breadcrumbs=array(
	'Branch Master'=>array('branchmaster/admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Branchcurrency', 'url'=>array('index')),
	array('label'=>'New Branch Currency', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create', 'cm_branch'=>$cm_branch )),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#branchcurrency-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Branch Currencies</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'branchcurrency-grid',
	//'dataProvider'=>$model->search(),
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'cm_branch',
		'cm_currency',
		'cm_description',
		'cm_exchangerate',
		'cm_active',
		/*
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
