<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Requisition'=>array('purchaseordhd/admin'),
	'Update Requisition Number',
);


$this->menu=array(
	array('label'=>'Manage Requisition Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageRequisitionNum')),
); 
?>

<h1>Update Requisition Number</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
