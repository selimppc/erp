<?php
/* @var $this PurchaseordhdController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Purchase',
);

$this->menu=array(
	array('label'=>'New Purchase Order Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Purchase Order Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Purchase Order Header</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
