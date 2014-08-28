<?php
/* @var $this PurchaseorddtController */
/* @var $model Purchaseorddt */

$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	// $model->id,
	'View Purchase Order Detail',
);

$this->menu=array(
	array(
		'label'=>'Manage Purchase Order Details', 
		 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}',
		'url'=>array('PurchaseOrderNumberS1', 'pp_purordnum'=>$pp_purordnum, 'pp_status'=>$pp_status,    ),
	),
);
?>

<h1>View Purchase Order Details # <?php echo $model->pp_purordnum; ?></h1>

<br>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'pp_purordnum',
		//'pp_serialno',
		'cm_code',
		'pp_quantity',
		'pp_grnqty',
		'pp_unit',
		'pp_unitqty',
		'pp_purchasrate',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
