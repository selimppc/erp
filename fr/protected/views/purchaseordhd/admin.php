<?php
/* @var $this PurchaseordhdController */
/* @var $model Purchaseordhd */

$this->breadcrumbs=array(
	'Purchase'=>array('admin'),
	'Manage Purchase Order Header',
);

$this->menu=array(
	//array('label'=>'List Purchase Order', 'url'=>array('index')),
	array('label'=>'New Purchase Order Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Purchase Order Number', 'url'=>array('transaction/ManagePurchaseOrdNum')),
	),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#purchaseordhd-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Purchase Order Header</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchaseordhd-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		//'pp_purordnum',
		array(
					'class'=>'CLinkColumn',
                    'header'=>'Purchase Order Number',
                    'labelExpression'=>'$data->pp_purordnum',
					'urlExpression'=>'array("Purchaseorddt/PurchaseOrderNumberS1","pp_purordnum"=>$data->pp_purordnum, "pp_status"=>$data->pp_status )',
                    ),
		'pp_date',
		//'cm_supplierid',
        'cm_orgname',
		'pp_requisitionno',
		//'pp_payterms',
		'pp_deliverydate',
		'cm_description',
		//'pp_taxrate',
		//'pp_taxamt',
		'pp_currency',
		'pp_discrate',
		'pp_discamt',
		'pp_amount',
		'pp_status',
		/*
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'template'=>'{view}{update}{delete}{approved}',
			'buttons'=>array
			(
				'update' => array
				(
					'label'=>'update',
					'visible'=>'$data->pp_status=="Open"',
					//'options'=>array('onclick'=>$model->id),
				),   
				
				'delete' => array
				(
					'label'=>'delete',
					'visible'=>'$data->pp_status=="Open"',
					//'options'=>array('onclick'=>$model->id),
				),  

				'approved' => array(
                    'label'=>'approve',     // text label of the button
                    'url'=>'Yii::app()->createUrl("purchaseordhd/ApproveStatus/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->pp_status=="Open" OR $data->pp_status=="Part Received"',
				),
					
			),
		),
	),
)); ?>
