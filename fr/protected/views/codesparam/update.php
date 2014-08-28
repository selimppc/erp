<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Product Master'=>array('productmaster/admin'),
	//'View'=>array('view', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code),
	'Settings >> Update',
);

$this->menu=array(
	//array('label'=>'List Codesparam', 'url'=>array('index')),
	//array('label'=>'Create Codesparam', 'url'=>array('create')),
	//array('label'=>'View Codesparam', 'url'=>array('view', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code)),
	//array('label'=>'Manage Codesparam', 'url'=>array('admin')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Product Class Manage', 'url'=>array('productmaster/ProductClass')),
				array('label'=>'Product Group Manage', 'url'=>array('productmaster/ProductGroup')),
				array('label'=>'Product Category Manage', 'url'=>array('productmaster/ProductCategory')),
				array('label'=>'Unit Of Measurement Manage', 'url'=>array('productmaster/UnitOfMeasurement')),
	),
	),
); 
?>

<h1>Update <?php echo $model->cm_type; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
