<?php
/* @var $this RequisitiondtController */
/* @var $model Requisitiondt */

$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	'View Requisition Entry Detail',
);

$this->menu=array(
	//array('label'=>'List Requisition Details', 'url'=>array('index')),
	//array('label'=>'Create Requisition Details', 'url'=>array('create')),
	//array('label'=>'Update Requisition Details', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Requisition Details', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Requisition Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin' , 'pp_requisitionno'=>$pp_requisitionno)),
);
?>

<h1>View Requisition Details # <?php echo $model->pp_requisitionno; ?></h1>
<p>&nbsp;</p>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'pp_requisitionno',
		'cm_code',
		'pp_unit',
		'pp_quantity',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>





