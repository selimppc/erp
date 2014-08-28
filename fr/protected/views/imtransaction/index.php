<?php
/* @var $this ImtransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Opening Stock',
);

$this->menu=array(
	array('label'=>'New Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Opening Stock', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Opening Stock</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
