<?php
/* @var $this RequisitiondtController */
/* @var $model Requisitiondt */

$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Requisition Entry Detail',
);

$this->menu=array(
	array('label'=>'View Requisition Details', 'url'=>array('view', 'id'=>$model->id, 'pp_requisitionno'=>$pp_requisitionno)),
	array('label'=>'Manage Requisition Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin', 'pp_requisitionno'=>$pp_requisitionno)),
);
?>

<h1>Update Requisition Details # <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>