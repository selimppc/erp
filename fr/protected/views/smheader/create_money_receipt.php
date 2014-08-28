<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Money Receipt'=>array('adminmoneyreceipt'),
	'Create'=>array('createmoneyreceipt'),
);

$this->menu=array(
	array('label'=>'Manage Money Receipt', 'url'=>array('adminmoneyreceipt')),
);
?>

<?php $this->renderPartial('_form_money_receipt', array('model'=>$model, 'mralc'=>$mralc, 'cname'=>$cname, 'ramt'=>$ramt, )); ?>