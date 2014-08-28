<?php
/* @var $this GroupthreeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Groupthrees',
);

$this->menu=array(
	array('label'=>'Create Groupthree', 'url'=>array('create')),
	array('label'=>'Manage Groupthree', 'url'=>array('admin')),
);
?>

<h1>Groupthrees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
