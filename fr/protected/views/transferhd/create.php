<?php
/* @var $this TransferhdController */
/* @var $model Transferhd */

$this->breadcrumbs=array(
	'Transfer'=>array('admin'),
	'New Transfer Header',
);

$this->menu=array(
	//array('label'=>'List Transfer Header', 'url'=>array('index')),
	array('label'=>'Manage Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Transfer Header</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>