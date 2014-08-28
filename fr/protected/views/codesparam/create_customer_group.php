<?php
$this->breadcrumbs=array(
	'Customer Master'=>array('customermst/admin'),
	'Settings >> New Customer Group',
);

$this->menu=array(
	array('label'=>'New Customer Group', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('codesparam/CreateProductGroup')),
    array('label'=>'Manage Customer Group', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('codesparam/ManageCustomerGroup')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Customer Group', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('codesparam/ManageCustomerGroup')),
				array('label'=>'Market', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('codesparam/ManageMarket')),
	),
	),
);
?>

<h1>New Customer Group</h1>
<?php echo $this->renderPartial('_form_customer_group', array('model'=>$model)); ?>
