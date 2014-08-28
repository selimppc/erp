<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'Settings >> Create GRN ',
);

$this->menu=array(
	array('label'=>'New GRN Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateGRNnumnber')),
    array('label'=>'Manage GRN Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageGRNnumnber')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'GRN Number', 'url'=>array('transaction/ManageGRNnumnber')),
	),
	),
);
?>

<h1>New GRN Number </h1>
<?php echo $this->renderPartial('_from_grn_number', array('model'=>$model)); ?>
