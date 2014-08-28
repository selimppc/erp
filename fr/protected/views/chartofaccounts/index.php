<?php
/* @var $this ChartofaccountsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Chart of Accounts',
);

$this->menu=array(
	array('label'=>'Create Chart of Accounts', 'url'=>array('create')),
	array('label'=>'Manage Chart of Accounts', 'url'=>array('admin')),
);
?>

<h1>Chart of Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
