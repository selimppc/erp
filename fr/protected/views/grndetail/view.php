<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'GRN Detail'=>array('admin'),
	//$model->id,
	'View GRN Detail',
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	array('label'=>'New View GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'Update Grndetail', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Grndetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View GRN Detail </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'im_grnnumber',
		'cm_code',
		'im_BatchNumber',
		'im_ExpireDate',
		'im_RcvQuantity',
		'im_costprice',
		'im_unit',
		'im_unitqty',
		'im_rowamount',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
