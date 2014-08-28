<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Transactions'=>array('admin'),
	'View'=>array('view', 'cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Transaction', 'url'=>array('index')),
	array('label'=>'New Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	//array('label'=>'View Transaction', 'url'=>array('view', 'cm_type'=>$model->cm_type, 'cm_trncode'=>$model->cm_trncode)),
	array('label'=>'Manage Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
); 
?>

<h1>Update Client</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
