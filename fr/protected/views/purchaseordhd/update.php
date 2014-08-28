<?php
/* @var $this PurchaseordhdController */
/* @var $model Purchaseordhd */

$this->breadcrumbs=array(
	'Purchase'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Purchase Order Header',
);

$this->menu=array(
	//array('label'=>'List Purchase Order', 'url'=>array('index')),
	//array('label'=>'Create Purchase Order', 'url'=>array('create')),
	//array('label'=>'View Purchase Order', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Purchase Order Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Purchase Order </h1>

<?php $this->renderPartial('_form_update1', array('model'=>$model)); ?>