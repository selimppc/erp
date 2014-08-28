<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'Manage GRN'=>array('purchaseordhd/ViewGrn'),
	'Manage GRN Detail',
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	//array('label'=>'Create Grndetail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create', 'vGrnNumber'=>$im_grnnumber, 'pp_purordnum'=>$im_purordnum,)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#grndetail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<h1>Manage Grn Details</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grndetail-grid',
	'dataProvider'=>VwGrndetail::model()->search($im_grnnumber),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		'im_grnnumber',
		'cm_code',
		'cm_name',
		'im_BatchNumber',
		'im_ExpireDate',
		'im_RcvQuantity',
		'im_costprice',
		'im_unit',
		'im_unitqty',
		'im_rowamount',
	/*
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
		'class'=>'CButtonColumn',
		'template'=>'{update}{delete}',
		'header'=>'Action',
		'buttons'=>array
            (
				'update' => array
				(
					'url'=>
                    'Yii::app()->createUrl("grndetail/UpdateGrndt/", 
                         array("id"=>$data->id, "im_grnnumber"=>$data->im_grnnumber, "cm_code"=>$data->cm_code,
					))',
				),   
				
				'delete' => array
				(
					'url'=>
                    'Yii::app()->createUrl("grndetail/delete/", 
                         array("id"=>$data->id
					))',
				), 
			)
		)
	),
)); ?>
