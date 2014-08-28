<?php
/* @var $this RequisitionhdController */
/* @var $model Requisitionhd */

$this->breadcrumbs=array(
	'Requisition'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Requisition Header',
);

$this->menu=array(
	//array('label'=>'List Requisition ', 'url'=>array('index')),
	array('label'=>'New Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Requisition ', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Requisition Header </h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>