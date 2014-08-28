<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'GRN Detail'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update GRN Detail',
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	array('label'=>'New GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Grndetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update GRN Detail </h1>

<?php $this->renderPartial('_form', array('model'=>$model,)); ?>