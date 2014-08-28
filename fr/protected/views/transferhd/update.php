<?php
/* @var $this TransferhdController */
/* @var $model Transferhd */

$this->breadcrumbs=array(
	'Transfer'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Transfer Header',
);

$this->menu=array(
	//array('label'=>'List Transfer Header', 'url'=>array('index')),
	array('label'=>'New Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Transfer Header', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Transfer Header </h1>

<?php $this->renderPartial('_form_update', array('model'=>$model)); ?>