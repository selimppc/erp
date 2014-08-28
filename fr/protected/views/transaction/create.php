<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	'New Requisition Number',
);

$this->menu=array(
	array('label'=>'New Requisition Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/create')),
    array('label'=>'Manage Requisition Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageRequisitionNum')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Requisition Number', 'url'=>array('transaction/ManageRequisitionNum')),
	),
	),	
);
?>

<h1>New Requisition Number</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
