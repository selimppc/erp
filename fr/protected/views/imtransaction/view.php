<?php
/* @var $this ImtransactionController */
/* @var $model Imtransaction */

$this->breadcrumbs=array(
	'Opening Stock'=>array('admin'),
	//$model->id,
	'View Recieve Stock ',
);

$this->menu=array(
	//array('label'=>'List Recieve Stock', 'url'=>array('index')),
	array('label'=>'New Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'Update Recieve Stock', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Recieve Stock', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Opening Stock  </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'im_number',
		'cm_code',
		'im_storeid',
		'im_BatchNumber',
		'im_date',
		'im_ExpireDate',
		'im_quantity',
		'im_sign',
		'im_unit',
		'im_rate',
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
	),
)); ?>
