<?php
/* @var $this PurchaseorddtController */
/* @var $model Purchaseorddt */

$this->breadcrumbs=array(
	'Purchase '=>array('purchaseordhd/admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Purchase Order Detail',
);

$this->menu=array(
	//array('label'=>'List Purchase Order Details', 'url'=>array('index')),
	//array('label'=>'Create Purchase Order Details', 'url'=>array('create')),
	array('label'=>'View Purchase Order Details', 'url'=>array('view', 'id'=>$model->id , 'pp_purordnum'=>$pp_purordnum, 'pp_status'=>$pp_status)),
	array('label'=>'Manage Purchase Order Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('PurchaseOrderNumberS1', 'pp_purordnum'=>$pp_purordnum, 'pp_status'=>$pp_status )),
);
?>

<h1>Update Purchase Order Details </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>