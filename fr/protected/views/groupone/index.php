<?php
/* @var $this GrouponeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Group One',
);

$this->menu=array(
	array('label'=>'New Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Group One</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
