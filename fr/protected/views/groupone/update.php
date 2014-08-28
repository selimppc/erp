<?php
/* @var $this GrouponeController */
/* @var $model Groupone */

$this->breadcrumbs=array(
	'Group One'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'New Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'View Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/view_a.png" /></span>{menu}', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Group One <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>