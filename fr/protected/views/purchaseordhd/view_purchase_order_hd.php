<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'Create GRN from Purchase Order',
);

$this->menu=array(
	//array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'GRN', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/grn_a.png" /></span>{menu}', 'url'=>array('purchaseordhd/ViewPurchaseOrderHd')),
	array('label'=>'Manage GRN', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('purchaseordhd/ViewGrn')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'GRN Number', 'url'=>array('transaction/ManageGRNnumnber')),

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




<h1> Create GRN from Purchase Order</h1>
<br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	
	'columns'=>array(
		'id',
		'pp_purordnum',
		'cm_supplierid',
		'cm_orgname',
		'Order_Date',
		'Delivery_Date',
		'pp_status',

    	
        array(
            'class'=>'CButtonColumn',
        	'header' => 'Action',
			'template' => '{GRN}',
			
			'buttons' => array(
                   'GRN' => array(
                    'label'=>'Create GRN',     // text label of the button
                    'url'=>'Yii::app()->createUrl("purchaseordhd/CreateGRN/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/create.png', 
        			'visible' => '$data->pp_status=="Approved" OR $data->pp_status=="Part Received"',
					),
             
        	),
	),
))); ?>
