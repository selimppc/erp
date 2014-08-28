<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Opening Balance'=>array('admin'),
	'New Opening Balance',
);

$this->menu=array(
	array('label'=>'Manage Opening Balance', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Voucher No', 'url'=>array('transaction/managevoucherno')),
		),
	),
);
?>

<h1>New Opening Balance </h1>

<?php $this->renderPartial('_form_opening_balance', array('model'=>$model)); ?>