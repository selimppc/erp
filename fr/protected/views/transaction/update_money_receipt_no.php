<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Money Receipt'=>array('smheader/adminmoneyreceipt'),
	'Update Money Receipt No',
);


$this->menu=array(
	array('label'=>'Manage Money Receipt No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageMoneyReceiptNo')),
); 
?>

<h1>Update Money Receipt No</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
