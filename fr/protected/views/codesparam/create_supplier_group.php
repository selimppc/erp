<?php
$this->breadcrumbs=array(
	'Supplier Master'=>array('suppliermaster/admin'),
	'Settings >> New Supplier Group',
);

$this->menu=array(
	array('label'=>'New Supplier Group', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('codesparam/CreateSupplierGroup')),
    array('label'=>'Manage Supplier Group', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('suppliermaster/SupplierGroup')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Supplier Group Manage', 'url'=>array('suppliermaster/SupplierGroup')),
	),
	),
);
?>

<h1>New Supplier Group</h1>
<?php echo $this->renderPartial('_form_supplier_group', array('model'=>$model)); ?>
