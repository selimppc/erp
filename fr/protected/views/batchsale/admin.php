<?php
/* @var $this BatchsaleController */
/* @var $model Batchsale */

$this->breadcrumbs=array(
	'Batch Sales'=>array('admin')
);

?>

<h1>Batch Sales # <?php echo $sm_number; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'batchsale-grid',
	'dataProvider'=>$model->search($sm_number),
	'filter'=>$model,
	//'dataProvider'=>$dataProvider,
	'columns'=>array(
		//'id',
		'sm_number',
		'cm_code',
		'cm_name',
		'sm_batchnumber',
		'sm_expdate',
		'sm_unit',
		'sm_quantity',
		/*
		'sm_quantity',
		'sm_bonusqty',
		'sm_rate',
		'sm_tax_rate',
		'sm_tax_amt',
		'sm_line_amt',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		
		array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>
