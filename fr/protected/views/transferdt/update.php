<?php
/* @var $this TransferdtController */
/* @var $model Transferdt */

$this->breadcrumbs=array(
	'Transfer'=>array('transferhd/admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update Transfer Detail',
);

$this->menu=array(
	//array('label'=>'List Transfer Detail', 'url'=>array('index')),
	array('label'=>'New Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create','im_transfernum'=>$im_transfernum)),
	//array('label'=>'View Transfer Detail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin','im_transfernum'=>$im_transfernum)),
);
?>

<h1>Update Transfer Detail </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>