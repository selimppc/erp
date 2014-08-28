<?php
/* @var $this SuppliermasterController */
/* @var $model Suppliermaster */

$this->breadcrumbs=array(
	'Supplier Masters'=>array('admin'),
	//$model->cm_supplierid=>array('view','id'=>$model->cm_supplierid),
	'Update Supplier',
);

$this->menu=array(
	//array('label'=>'List Supplier Master', 'url'=>array('index')),
	array('label'=>'New Supplier Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Supplier Master', 'url'=>array('view', 'cm_supplierid'=>$model->cm_supplierid)),
	array('label'=>'Manage Supplier Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Supplier Master </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>