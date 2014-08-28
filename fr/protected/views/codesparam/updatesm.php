<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Supplier Master'=>array('suppliermaster/admin'),
	//'View'=>array('viewsm', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code),
	'Settings >> Update Supplier Group',
);

$this->menu=array(
	//array('label'=>'List Codesparam', 'url'=>array('index')),
	//array('label'=>'Create Codesparam', 'url'=>array('create')),
	//array('label'=>'View Codesparam', 'url'=>array('view', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code)),
	//array('label'=>'Manage Codesparam', 'url'=>array('admin')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Supplier Group Manage', 'url'=>array('suppliermaster/SupplierGroup')),
	),
	),
); 
?>

<h1>Update <?php echo $model->cm_type; ?></h1>

<?php echo $this->renderPartial('_form_supplier_group', array('model'=>$model)); ?>
