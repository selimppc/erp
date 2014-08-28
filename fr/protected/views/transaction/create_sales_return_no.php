<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Sales Return'=>array('smheader/adminsalesreturn'),
	'New Sales Return Number',
);

$this->menu=array(

    array('label'=>'Manage Sales Return Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageSalesReturnNo')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Sales Return Number', 'url'=>array('transaction/CreateSalesReturnNo')),
	),
	),
);
?>

<h1>New Sales Return Number </h1>
<?php echo $this->renderPartial('_from_sales_return_no', array('model'=>$model)); ?>
