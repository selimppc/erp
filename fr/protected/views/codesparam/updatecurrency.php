<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Branch Master'=>array('branchmaster/admin'),
	//'View'=>array('viewcurrency', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code),
	'Settings >> Update Branch Currency',
);

$this->menu=array(
	//array('label'=>'List Codesparam', 'url'=>array('index')),
	//array('label'=>'Create Codesparam', 'url'=>array('create')),
	//array('label'=>'View Codesparam', 'url'=>array('view', 'cm_type'=>$model->cm_type, 'cm_code'=>$model->cm_code)),
	//array('label'=>'Manage Codesparam', 'url'=>array('admin')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Currency', 'url'=>array('branchmaster/BranchCurrency')),
	),
	),
); 
?>

<h1>Update <?php echo $model->cm_type; ?></h1>

<?php echo $this->renderPartial('_form_branch_currency', array('model'=>$model)); ?>
