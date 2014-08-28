<?php
/* @var $this GrouptwoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Group Two',
);

$this->menu=array(
	//array('label'=>'Create Grouptwo', 'url'=>array('create')),
	array('label'=>'Manage Group Two', 'url'=>array('admin')),
);
?>

<h1>Group Two</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
