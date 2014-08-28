<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Sm Headers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Smheader', 'url'=>array('create')),
	array('label'=>'View Smheader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Smheader', 'url'=>array('admin')),
);
?>

<h1>Update Smheader <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>