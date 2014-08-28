<?php
$this->breadcrumbs=array(
	'Product Master'=>array('productmaster/admin'),
	'Settings >> New Product Class',
);

$this->menu=array(
	array('label'=>'New Product Class', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('codesparam/CreateProductClass')),
    array('label'=>'Manage Product Class', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('productmaster/ProductClass')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Product Class Manage', 'url'=>array('productmaster/ProductClass')),
				array('label'=>'Product Group Manage', 'url'=>array('productmaster/ProductGroup')),
				array('label'=>'Product Category Manage', 'url'=>array('productmaster/ProductCategory')),
				array('label'=>'Unit Of Measurement Manage', 'url'=>array('productmaster/UnitOfMeasurement')),
		),
	),
);
?>

<h1>New Product Class</h1>
<?php echo $this->renderPartial('_form_product_class', array('model'=>$model)); ?>
