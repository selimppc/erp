<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Product Master'=>array('productmaster/admin'),
	'Settings >> View',
);

$this->menu=array(
	//array('label'=>'List Codesparam', 'url'=>array('index')),
	//array('label'=>'Create Codesparam', 'url'=>array('create')),
	array('label'=>'Update ', 'url'=>array('update', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code)),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Product Class Manage', 'url'=>array('productmaster/ProductClass')),
				array('label'=>'Product Group Manage', 'url'=>array('productmaster/ProductGroup')),
				array('label'=>'Product Category Manage', 'url'=>array('productmaster/ProductCategory')),
				array('label'=>'Unit Of Measurement Manage', 'url'=>array('productmaster/UnitOfMeasurement')),
	),
	),
	//array('label'=>'Delete Codesparam', 'url'=>'delete', 
	//      'linkOptions'=>array('submit'=>array('delete',
	//                                           'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code),
	//								'confirm'=>'Are you sure you want to delete this item?'),
	//								'visible'=> $model->cm_active=="1",
	//								),
	//array('label'=>'Manage Codesparam', 'url'=>array('admin')),
);
?>

<h1>View <?php echo $model->cm_type; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cm_type',
		'cm_code',
		'am_code',
		'cm_desc',
		'cm_active',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
