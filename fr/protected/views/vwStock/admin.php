<?php
/* @var $this VwStockController */

$this->breadcrumbs=array(
	'Stock View '=>array('admin'),
	'Admin',
);
?>



<h1>Stock View</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferdt-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'cm_code',
		'cm_name',
		'im_BatchNumber',
		'im_ExpireDate',
		'im_storeid',
		'im_rate',
		'im_unit',
		'issueqty',
		'saleqty',
		'inhandqty',
		'available',
	),
)); ?>
