<?php
/* @var $this GrouptwoController */
/* @var $model Grouptwo */

$this->breadcrumbs=array(
	'Group Two'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'View Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/view_a.png" /></span>{menu}', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Group Two <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>