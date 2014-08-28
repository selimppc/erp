<?php
/* @var $this GrouptwoController */
/* @var $model Grouptwo */

$this->breadcrumbs=array(
	'Grouptwos'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'New Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Update Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/update_a.png" /></span>{menu}', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/delete_a.png" /></span>{menu}', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Group Two #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'am_groupone',
		'am_grouptwo',
		'am_description',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
