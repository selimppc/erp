<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Product Masters'=>array('admin'),
	//$model->cm_code=>array('view','id'=>$model->cm_code),
	'Update Product Master',
);

$this->menu=array(
	// array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'New Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Product Master', 'url'=>array('view', 'cm_code'=>$model->cm_code)),
	array('label'=>'Manage Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Update Product Master <?php echo $model->cm_code; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>