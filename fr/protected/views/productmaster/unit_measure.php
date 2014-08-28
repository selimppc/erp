<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Product Masters'=>array('productmaster/admin'),
	'Setting >> Unit Of Measurement',
);

$this->menu=array(
	//array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'New Unit Of Measurement', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('codesparam/UnitOfMeasurement')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Product Class Manage', 'url'=>array('productmaster/ProductClass')),
				array('label'=>'Product Group Manage', 'url'=>array('productmaster/ProductGroup')),
				array('label'=>'Product Category Manage', 'url'=>array('productmaster/ProductCategory')),
				array('label'=>'Unit Of Measurement Manage', 'url'=>array('productmaster/UnitOfMeasurement')),
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


<h1> Unit Of Measurement </h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$result,
	'columns'=>array(
		'cm_type',
		'cm_code',
		'cm_desc',
		'cm_active',
		//'inserttime',
		//'updatetime',
		'insertuser',
		//'updateuser',

    	
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
                'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("codesparam/view/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("codesparam/update/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                ),
                'delete'=> array
                (
                    'url'=>
                    'Yii::app()->createUrl("codesparam/delete/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                ),
            ),
        ),
	),
)); ?>
