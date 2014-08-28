<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Invoice'=>array('admin'),
	'New Invoice',
);

$this->menu=array(
	array('label'=>'Manage Invoice', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Invoice</h1>

<?php $this->renderPartial('_form_invoice_new', array('model'=>$model)); ?>