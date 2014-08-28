<?php
/* @var $this GroupthreeController */
/* @var $model Groupthree */

$this->breadcrumbs=array(
	'Group Three'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'New Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Update Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/update_a.png" /></span>{menu}', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Group Three #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'am_groupone',
		'am_grouptwo',
		'am_groupthree',
		'am_description',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
