<?php
/* @var $this PurchaseordhdController */
/* @var $model Purchaseordhd */

$this->breadcrumbs=array(
	'Purchase'=>array('admin'),
	'New Purchase Order Header',
);

$this->menu=array(
	//array('label'=>'List Purchase Order', 'url'=>array('index')),
	array('label'=>'Manage Purchase Order', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Purchase Order</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>