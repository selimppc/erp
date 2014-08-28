<?php
/* @var $this PurchaseordhdController */
/* @var $model Purchaseordhd */

$this->breadcrumbs=array(
	'Purchase Order'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Purchase Order', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Purchase Order #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pp_purordnum',
		'pp_date',
		'cm_supplierid',
		'pp_requisitionno',
		'pp_payterms',
		'pp_deliverydate',
		'pp_store',
		//'pp_taxrate',
		//'pp_taxamt',
		'pp_currency',
		'pp_discrate',
		'pp_discamt',
		'pp_amount',
		'pp_status',
		//'inserttime',
		//'updatetime',
		//'insertuser',
		//'updateuser',
	),
)); ?>
