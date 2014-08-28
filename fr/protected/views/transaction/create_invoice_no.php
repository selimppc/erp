<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Invoice'=>array('smheader/admin'),
	'New Invoice Number',
);

$this->menu=array(
	array('label'=>'New Invoice Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/createinvoiceno')),
    array('label'=>'Manage Invoice Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/manageinvoiceno')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Invoice Number', 'url'=>array('transaction/createinvoiceno')),
	),
	),
);
?>

<h1>New Invoice Number </h1>
<?php echo $this->renderPartial('_from_invoice_no', array('model'=>$model)); ?>
