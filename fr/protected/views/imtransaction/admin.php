<?php
/* @var $this ImtransactionController */
/* @var $model Imtransaction */

$this->breadcrumbs=array(
	'Opening Stock'=>array('admin'),
	'Manage Opening Stock ',
);

$this->menu=array(
	//array('label'=>'List Imtransaction', 'url'=>array('index')),
	array('label'=>'New Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'IM Transaction', 'url'=>array('transaction/ManageImTrn')),
	),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#imtransaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Opening Stock </h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'imtransaction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'im_number',
		'cm_code',
		'cm_name',
		'cm_description',
		'im_BatchNumber',
		//'im_date',
		'im_ExpireDate',
		'im_quantity',
		// 'im_sign',
		'im_unit',
		'im_rate',
/*
		'im_totalprice',
		'im_RefNumber',
		'im_RefRow',
		'im_note',
		'im_status',
		'im_voucherno',
		'cm_supplierid',
		'im_currency',
		'im_ExchangeRate',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
		),
	),
)); ?>
