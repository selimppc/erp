<?php
/* @var $this BranchmasterController */
/* @var $model Branchmaster */

$this->breadcrumbs=array(
	'Branch Master'=>array('admin'),
	//$model->cm_branch=>array('view','id'=>$model->cm_branch),
	'Update Branch Master',
);

$this->menu=array(
	//array('label'=>'List Branch Master', 'url'=>array('index')),
	//array('label'=>'Create Branch Master', 'url'=>array('create')),
	array('label'=>'View Branch Master', 'url'=>array('view', 'cm_branch'=>$model->cm_branch)),
	array('label'=>'Manage Branch Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Branch Master <?php echo $model->cm_branch; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>