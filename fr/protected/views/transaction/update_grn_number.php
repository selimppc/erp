<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'Update GRN Number',
);


$this->menu=array(
	array('label'=>'Manage GRN Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageGRNnumnber')),
); 
?>

<h1>Update GRN Number</h1>

<?php echo $this->renderPartial('_from_grn_number', array('model'=>$model)); ?>
