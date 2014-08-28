<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Sales Return'=>array('adminsalesreturn'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Sales Return', 'url'=>array('adminsalesreturn')),
);
?>


<?php $this->renderPartial('_form_sales_return', array('model'=>$model, 'smdetail'=>$smdetail, 'smheader'=>$smheader, 'sm_number'=>$sm_number, )); ?>