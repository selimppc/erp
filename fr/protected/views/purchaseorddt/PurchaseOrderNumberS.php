<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'Purchase Order Number',
);

$this->menu=array(
	// array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'New Purchase Order Detail',  'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}',
		'url'=>array('create','pp_purordnum'=>$pp_purordnum, 'pp_status'=>$pp_status),
		'visible'=>$pp_status=="Open",
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



<h1> Purchase Order Number</h1>

<?php 
	$viewarray = array
				(
					'label'=>'view',
					//'value'=>'function ($data , $row) use ($pp_status){return ($data["pp_status"]=="GRN Created")?"GRN Created":$status_names[$data["status"]];}',
					'url'=>'Yii::app()->createUrl("purchaseorddt/view/", array(
						"id"=>$data->id, "pp_purordnum"=>$data->pp_purordnum, "pp_status"=>$data->pp_status
						
					))', 
					//'click'=>'function(){alert("Going view!");}',
				);
				
	$updatearray = array
				(
					'label'=>'update',
					'url'=>'Yii::app()->createUrl("purchaseorddt/update/", array(
						"id"=>$data->id, "pp_purordnum"=>$data->pp_purordnum, "pp_status"=>$data->pp_status
						))',
					'visible'=>($pp_status=="Open"?'true':'false'),
				);
	$deletearray = array
				(
					'label'=>'delete',
					'visible'=>($pp_status=="Open"?'true':'false'),
				);
			
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$result,

	'columns'=>array(
		'id',
		'pp_purordnum',
		'cm_code',
		'pp_quantity',
		//'pp_grnqty',
		'pp_unit',
		'pp_unitqty',
		'pp_purchasrate',
		//array('name'=>"status",'value'=>'$data->pp_status'),
    	
        array(
            'class'=>'CButtonColumn',
			'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
            	'view' => $viewarray,
                'update' => $updatearray,   
				'delete' => $deletearray, 

            
        ),
	),
))); ?>
