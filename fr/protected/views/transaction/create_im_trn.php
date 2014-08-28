<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Recieve Stock'=>array('imtransaction/admin'),
	'New IM Transaction',
);

$this->menu=array(
	array('label'=>'New IM Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateImTrn')),
    array('label'=>'Manage IM Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageImTrn')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'IM Transaction', 'url'=>array('transaction/CreateImTrn')),
	),
	),
);
?>

<h1>New IM Transaxction </h1>
<?php echo $this->renderPartial('_from_im_trn', array('model'=>$model)); ?>
