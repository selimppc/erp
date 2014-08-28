<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	'Requisition Entry Detail',
);

$this->menu=array(
	//array('label'=>'List Requisition', 'url'=>array('index')),
	array('label'=>'New Requisition Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create', 'pp_requisitionno'=>$pp_requisitionno)),

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
		//'id',
		'pp_requisitionno',
		'cm_code',
		'pp_unit',
		'pp_quantity',
    	
        array(
            'class'=>'CButtonColumn',
			'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
            	'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("requisitiondt/view/", 
                                            array("id"=>$data->id, "pp_requisitionno"=>$data->pp_requisitionno
											))',
                ),
                
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("requisitiondt/update/", 
                                            array("id"=>$data->id, "pp_requisitionno"=>$data->pp_requisitionno
											))',
                ),

            
        ),
            
        ),
	),
)); ?>
