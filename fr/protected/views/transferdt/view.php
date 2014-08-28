<?php
/* @var $this TransferdtController */
/* @var $model Transferdt */

$this->breadcrumbs=array(
	'Transfer'=>array('transferhd/admin'),
	//$model->id,
	'View Transfer Detail',
);

$this->menu=array(
	//array('label'=>'List Transfer Detail', 'url'=>array('index')),
	array('label'=>'New Transfer Detail', 
			 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}',
			'url'=>array('create', 'im_transfernum'=>$im_transfernum),
			'visible'=>$im_status=="Open",
	),
	//array('label'=>'Update Transfer Detail', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Transfer Detail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transfer Detail', 'url'=>array('admin', 'im_transfernum'=>$im_transfernum, 'im_status'=>$im_status)),
);
?>

<h1>View Transfer Detail   </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'im_transfernum',
		'cm_code',
		'im_unit',
		'im_quantity',
		'im_rate',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
