<?php
/* @var $this ImtransactionController */
/* @var $model Imtransaction */

$this->breadcrumbs=array(
	'Opening Stock'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Opening Stock ',
);

$this->menu=array(
	//array('label'=>'List Recieve Stock', 'url'=>array('index')),
	array('label'=>'New Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Recieve Stock', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Opening Stock </h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>