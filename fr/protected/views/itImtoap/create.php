<?php
/* @var $this ItImtoapController */
/* @var $model ItImtoap */

$this->breadcrumbs=array(
	'Module Interface'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List ItImtoap', 'url'=>array('index')),
	array('label'=>'Manage Module Interface', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Create Module Interface</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>