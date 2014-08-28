<?php
/* @var $this ImtransactionController */
/* @var $model Imtransaction */

$this->breadcrumbs=array(
	'Opening Stock'=>array('admin'),
	'New Opening Stock ',
);

$this->menu=array(
	//array('label'=>'List Recieve Stock', 'url'=>array('index')),
	array('label'=>'Manage Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Opening Stock</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>