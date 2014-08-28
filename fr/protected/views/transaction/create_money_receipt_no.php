<?php
$this->breadcrumbs=array(
	'Money Receipt'=>array('smheader/adminmoneyreceipt'),
	'New Money Receipt Number',
);

$this->menu=array(

    array('label'=>'Manage Money Receipt Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageMoneyReceiptNo')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Money Receipt Number', 'url'=>array('transaction/CreateMoneyReceiptNo')),
	),
	),
);
?>

<h1>New Money Receipt Number </h1>
<?php echo $this->renderPartial('_from_sales_return_no', array('model'=>$model)); ?>
