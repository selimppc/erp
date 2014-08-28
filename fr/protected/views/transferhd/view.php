<?php
/* @var $this TransferhdController */
/* @var $model Transferhd */

$this->breadcrumbs=array(
	'Transfer'=>array('admin'),
	//$model->id,
	'View Transfer Header',
);

$this->menu=array(
	//array('label'=>'List Transfer Header', 'url'=>array('index')),
	array('label'=>'New Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'Update Transfer Header', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Transfer Header', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Transfer Header </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'im_transfernum',
		'im_date',
		'im_condate',
		'im_note',
		'im_fromstore',
		'im_tostore',
		'im_status',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
