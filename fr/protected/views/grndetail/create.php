<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'GRN '=>array('purchaseordhd/ViewGrn'),
	'New GRN Detail',
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	array('label'=>'Manage GRN ', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('purchaseordhd/ViewGrn')),
);
?>

<h1>New GRN Detail</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'pp_purordnum'=>$pp_purordnum, 'im_grnnumber'=>$im_grnnumber)); ?>