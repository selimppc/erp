<?php
$this->breadcrumbs=array(
	'Transfer'=>array('transferhd/admin'),
	'New IM Transfer Number',
);

$this->menu=array(
	array('label'=>'New IM Transfer Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateImTrnNum')),
    array('label'=>'Manage IM Transfer Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageImTranNum')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'IM Transfer Number', 'url'=>array('transaction/ManageImTranNum')),
	),
	),
);
?>

<h1>New IM Transfer Number </h1>
<?php echo $this->renderPartial('_from_im_trn_num', array('model'=>$model)); ?>
