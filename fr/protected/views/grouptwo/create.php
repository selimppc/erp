<?php
/* @var $this GrouptwoController */
/* @var $model Grouptwo */

$this->breadcrumbs=array(
	'Chart of Accounts'=>array('chartofaccounts/admin'),
	'Settings',
	'New Group Two',
);

$this->menu=array(
	//array('label'=>'Manage Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Group Two</h1>

<?php $this->renderPartial('_form', array('model'=>$model, )); ?>