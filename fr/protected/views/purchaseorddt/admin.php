<?php
/* @var $this PurchaseorddtController */
/* @var $model Purchaseorddt */

$this->breadcrumbs=array(
	'Purchase '=>array('purchaseordhd/admin'),
	'Manage Purchase Order Details',
);

$this->menu=array(
	//array('label'=>'List Purchase Order Details', 'url'=>array('index')),
	array('label'=>'New Purchase Order Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#purchaseorddt-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Purchase Order Details</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchaseorddt-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'pp_purordnum',
		//'pp_serialno',
		'cm_code',
		'pp_quantity',
		'pp_grnqty',
		/*
		'pp_unit',
		'pp_unitqty',
		'pp_purchasrate',
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
