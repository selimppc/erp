<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Voucher Header'=>array('vouhcerheader/admin'),
	'Update Voucher No',
);


$this->menu=array(
	array('label'=>'Manage Voucher No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/managevoucherno')),
); 
?>

<h1>Update Voucher No</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
