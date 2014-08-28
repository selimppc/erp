<?php
/* @var $this BranchcurrencyController */
/* @var $model Branchcurrency */

$this->breadcrumbs=array(
	'Branch Master'=>array('branchmaster/admin'),
	'Create Branch Currency',
);

$this->menu=array(
	// array('label'=>'List Branchcurrency', 'url'=>array('index')),
	array('label'=>'Manage Branch Currency', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin', 'cm_branch'=>$model->cm_branch )),
);
?>

<h1>New Branch Currency</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>