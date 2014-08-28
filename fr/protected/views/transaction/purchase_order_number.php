<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Purchase Order '=>array('purchaseordhd/admin'),
	'New Purchase Order Number',
);

$this->menu=array(
	array('label'=>'New Purchase Order Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/createpo')),
    array('label'=>'Manage Purchase Order Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManagePurchaseOrdNum')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Purcahse Order Number', 'url'=>array('transaction/ManagePurchaseOrdNum')),
	),
	),
);
?>

<h1>New Purchase Order Number</h1>
<?php echo $this->renderPartial('purchase_order_form', array('model'=>$model)); ?>
