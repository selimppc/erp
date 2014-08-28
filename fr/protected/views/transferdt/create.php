<?php
/* @var $this TransferdtController */
/* @var $model Transferdt */

$this->breadcrumbs=array(
	'Transfer'=>array('transferhd/admin'),
	'New Transfer Detail',
);

$this->menu=array(
	//array('label'=>'List Transfer Detail', 'url'=>array('index')),
	array('label'=>'Manage Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin' ,'im_transfernum'=>$im_transfernum)),
);
?>

<h1>New Transfer Detail</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>