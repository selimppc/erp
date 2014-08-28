<?php
/* @var $this CustomermstController */
/* @var $model Customermst */

$this->breadcrumbs=array(
	'Customer Master'=>array('admin'),
	'New Customer',
);

$this->menu=array(
	array('label'=>'Manage Customer', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}',  'url'=>array('admin')),
);
?>

<h1>Create Customer Master</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>