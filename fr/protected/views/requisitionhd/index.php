<?php
/* @var $this RequisitionhdController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Requisition',
);

$this->menu=array(
	array('label'=>'New Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Requisition Header</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
