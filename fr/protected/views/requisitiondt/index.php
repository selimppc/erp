<?php
/* @var $this RequisitiondtController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Requisition Details',
);

$this->menu=array(
	array('label'=>'New Requisition Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Requisition Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Requisition Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
