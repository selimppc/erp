<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Product Masters'=>array('admin'),
	'New Product Master',
);

$this->menu=array(
	//array('label'=>'List Product Master', 'url'=>array('index')),
	array('label'=>'Manage Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Product Master</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>