<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'Update Purchase Order Number',
);


$this->menu=array(
	array('label'=>'Manage Purchase Order Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManagePurchaseOrdNum')),
); 
?>

<h1>Update Purchase Order Number </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
