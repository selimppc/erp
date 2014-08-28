<?php
/* @var $this TransferdtController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transfer Detail',
);

$this->menu=array(
	array('label'=>'New Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Transfer Detail</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
