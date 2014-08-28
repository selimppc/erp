<?php
/* @var $this GrouponeController */
/* @var $model Groupone */

$this->breadcrumbs=array(
		'Chart of Accounts'=>array('chartofaccounts/admin'),
		'Settings',
		'New Group One',
);

$this->menu=array(
	array('label'=>'Manage Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Create Group One</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>