<?php
/* @var $this GrndetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'GRN Detail',
);

$this->menu=array(
	array('label'=>'New GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>GRN Detail</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
