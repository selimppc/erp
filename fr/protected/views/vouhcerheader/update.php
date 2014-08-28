<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Voucher Header'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Vouhcerheader', 'url'=>array('index')),
	array('label'=>'Create Voucher Header', 'url'=>array('create')),
	array('label'=>'View Voucher Header', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Voucher Header', 'url'=>array('admin')),
);
?>

<h1>Update Voucher Header <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>