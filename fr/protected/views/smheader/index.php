<?php
/* @var $this SmheaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sm Headers',
);

$this->menu=array(
	array('label'=>'Manage Smheader', 'url'=>array('admin')),
);
?>

<h1>Sm Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
