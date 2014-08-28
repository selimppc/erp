<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Requisition'=>array('admin'),
	'Setting >> Class',
);

$this->menu=array(
	//array('label'=>'List Requisition', 'url'=>array('index')),
	array('label'=>'New Requisition Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Requisition Number', 'url'=>array('transaction/ManageRequisitionNum')),
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


<h1> Group</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$result,
	
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
