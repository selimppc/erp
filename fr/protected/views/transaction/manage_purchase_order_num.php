<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'Purchase Order Number',
);

$this->menu=array(
	//array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'New Purchase Order Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/createpo')),
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
	$('#productmaster-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>




<h1> Manage Purchase Order Number</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$result,
	
	'columns'=>array(
		'cm_type',
		'cm_trncode',
		'cm_branch',
		'cm_lastnumber',
		'cm_increment',
		'cm_active',
		
		array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
                'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/ViewPurchaseOrderNumber/", 
                                            array("cm_type"=>$data->cm_type, "cm_trncode"=>$data->cm_trncode
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/UpdatePurchaseOrderNumber/", 
                                            array("cm_type"=>$data->cm_type, "cm_trncode"=>$data->cm_trncode
											))',
                ),
                'delete'=> array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/delete/", 
                                            array("cm_type"=>$data->cm_type, "cm_trncode"=>$data->cm_trncode
											))',
                ),
            ),
        ),

))); ?>
