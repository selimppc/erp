<?php
/* @var $this RequisitionhdController */
/* @var $model Requisitionhd */

$this->breadcrumbs=array(
	'Requisition'=>array('admin'),
	'New Requisition Header ',
);

$this->menu=array(
	//array('label'=>'List Requisition ', 'url'=>array('index')),
	array('label'=>'Manage Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Requisition Header</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>