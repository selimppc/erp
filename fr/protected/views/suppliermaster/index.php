<?php
/* @var $this SuppliermasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Supplier Masters',
);

$this->menu=array(
	array('label'=>'New Supplier Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Supplier Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Supplier Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
