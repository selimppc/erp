<?php
/* @var $this CustomermstController */
/* @var $model Customermst */

$this->breadcrumbs=array(
	'Customer Master'=>array('admin'),
	$model->cm_cuscode,
);

$this->menu=array(
	array('label'=>'New Customer', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}',  'url'=>array('create')),
	array('label'=>'Manage Customer', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}',  'url'=>array('admin')),
);
?>

<h1>View Customer Master # <?php echo $model->cm_cuscode; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cm_cuscode',
		'cm_name',
		'cm_address',
		'cm_territory',
		'cm_cellnumber',
		'cm_phone',
		'cm_fax',
		'cm_email',
		'cm_branch',
		'cm_market',
		'cm_sp',
		'cm_creditlimit',
		'cm_hub',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
