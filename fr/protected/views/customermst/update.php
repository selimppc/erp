<?php
/* @var $this CustomermstController */
/* @var $model Customermst */

$this->breadcrumbs=array(
	'Customer Master'=>array('admin'),
	$model->cm_cuscode=>array('view','id'=>$model->cm_cuscode),
	'Update',
);

$this->menu=array(
	array('label'=>'New Customer', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}',  'url'=>array('create')),
	array('label'=>'Manage Customer ', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}',  'url'=>array('admin')),
);
?>

<h1>Update Customer Master <?php echo $model->cm_cuscode; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>