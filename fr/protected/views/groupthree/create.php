<?php
/* @var $this GroupthreeController */
/* @var $model Groupthree */

$this->breadcrumbs=array(
		'Chart of Accounts'=>array('chartofaccounts/admin'),
		'Settings',
		'New Group Three',
);

$this->menu=array(
	//array('label'=>'Manage Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Group Three</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>