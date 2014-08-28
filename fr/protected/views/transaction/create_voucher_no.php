<?php
$this->breadcrumbs=array(
	'Voucher Header'=>array('vouhcerheader/admin'),
	'New Voucher Number',
);

$this->menu=array(

    array('label'=>'Manage Voucher Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/managevoucherno')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Voucher Number', 'url'=>array('transaction/createvoucherno')),
	),
	),
);
?>

<h1>New Voucher Number </h1>
<?php echo $this->renderPartial('_from_voucher_no', array('model'=>$model)); ?>
