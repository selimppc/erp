<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'View Purchase Order Number',
);

$this->menu=array(
	//array('label'=>'List Transaction', 'url'=>array('index')),
	//array('label'=>'Create Transaction', 'url'=>array('create')),
	//array('label'=>'Update Transaction', 'url'=>array('update', 'cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode)),
	//array('label'=>'Delete Transaction', 'url'=>'delete',  'linkOptions'=>array('submit'=>array('delete',  'cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Purchase Order Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManagePurchaseOrdNum')),
);
?>

<h1>View <?php echo $cm_type ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cm_type',
		'cm_trncode',
		'cm_branch',
		'cm_lastnumber',
		'cm_increment',
		'cm_active',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>