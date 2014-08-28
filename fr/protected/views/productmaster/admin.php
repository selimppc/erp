<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Product Masters'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Product Master', 'url'=>array('index')),
	array('label'=>'New Product Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create') ),
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



<h1>Manage Productmasters</h1>



<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php  $this->renderPartial('_search',array(
	 'model'=>$model,
)); ?>
</div><!-- search-form -->




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'productmaster-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'cm_code',
		'cm_name',
		'cm_description',
		'cm_class',
		'cm_group',
		'cm_category',
		/*
		'cm_sellrate',
		'cm_costprice',
		'cm_sellunit',
		'cm_sellconfact',
		'cm_purunit',
		'cm_purconfact',
		'cm_stkunit',
		'cm_stkconfac',
		'cm_packsize',
		'cm_stocktype',
		'cm_generic',
		'cm_supplierid',
		'cm_mfgcode',
		'cm_maxlevel',
		'cm_minlevel',
		'cm_reorder',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
                'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("productmaster/view/", 
                                            array("cm_code"=>$data->cm_code, 
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("productmaster/update/", 
                                            array("cm_code"=>$data->cm_code,
											))',
                ),
                'delete'=> array
                (
                    'url'=>
                    'Yii::app()->createUrl("productmaster/delete/", 
                                            array("cm_code"=>$data->cm_code,
											))',
                ),
            ),
		),
	),
)); ?>



