<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Product Masters'=>array('admin'),
	//$model->cm_code,
	'View Product Master'
);

$this->menu=array(
	// array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'New Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'Update Product Master', 'url'=>array('update', 'id'=>$model->cm_code)),
	//array('label'=>'Delete Product Master', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cm_code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Product Master #<?php echo $model->cm_code; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cm_code',
		'cm_name',
		'cm_description',
		'cm_class',
		'cm_group',
		'cm_category',
		'cm_sellrate',
		'cm_costprice',
		'cm_sellunit',
		'cm_sellconfact',
		'cm_purunit',
		'cm_purconfact',
		'cm_stkunit',
		'cm_stkconfac',
		'cm_packsize',
		'cm_stocktype',
		'cm_generic',
		'cm_supplierid',
		'cm_mfgcode',
		'cm_maxlevel',
		'cm_minlevel',
		'cm_reorder',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
