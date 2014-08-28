<?php
/* @var $this PurchaseorddtController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'Purchase Order Detail'
);

$this->menu=array(
	///array('label'=>'Create Purchase Order Details', 'url'=>array('create')),
	array('label'=>'Manage Purchase Order Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Purchase Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
