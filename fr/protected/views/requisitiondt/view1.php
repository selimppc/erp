<?php
/* @var $this RequisitiondtController */
/* @var $model Requisitiondt */

$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#requisitiondt-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<h1> Requisition Details </h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employee-view-grid',
	'dataProvider'=>$model->searchEmployees(),
    'filter'=>$model,
	'columns'=>array(
		//'id',
		'pp_requisitionno',
		'cm_code',
		'pp_unit',
		'pp_quantity',

		'cm_supplierid',
		'pp_date',
		'pp_branch',
		'pp_note',
		'pp_status',
	
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>





