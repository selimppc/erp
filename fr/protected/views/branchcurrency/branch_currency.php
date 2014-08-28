<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Requisition'=>array('index'),
	'Setting >> Requisition Detail',
);

$this->menu=array(
	//array('label'=>'List Requisition', 'url'=>array('index')),
	array('label'=>'New Requisition Detail', 'url'=>array('create', 'pp_requisitionno'=>$pp_requisitionno)),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Product Class', 'url'=>array('codesparam/CreateProductClass')),
				array('label'=>'Product Group', 'url'=>array('codesparam/CreateProductGroup')),
				array('label'=>'Product Category', 'url'=>array('codesparam/CreateProductCategory')),
				array('label'=>'Unit Of Measurement', 'url'=>array('codesparam/UnitOfMeasurement')),
	),
	),
);




Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#productmaster-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<h1> Requisition Detail # <?php echo $pp_requisitionno; ?></h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$result,
	
	'columns'=>array(
		'id',
		'pp_requisitionno',
		'cm_code',
		'pp_unit',
		'pp_quantity',
    	
        array(
            'class'=>'CButtonColumn'
            
        ),
	),
)); ?>
