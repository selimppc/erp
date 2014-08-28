<?php
/* @var $this RequisitionhdController */
/* @var $model Requisitionhd */

$this->breadcrumbs=array(
	'Requisition'=>array('admin'),
	'Manage Requisition Header',
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
	$('#requisitionhd-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Requisition Header</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'requisitionhd-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'pp_requisitionno',
			array(
					'class'=>'CLinkColumn',
                    'header'=>'Requisition Number',
                    'labelExpression'=>'$data->pp_requisitionno',
                    //'urlExpression'=>'Yii::app()->createUrl("Purchaseorddt/PurchaseOrderNumberS1", array("pp_purordnum"=>$data->pp_purordnum))',
					'urlExpression'=>'array("requisitiondt/RequisitionNumber","pp_requisitionno"=>$data->pp_requisitionno)',
					//'linkHtmlOptions'=>array('target'=>'_blank'),  
                    ),
		'cm_supplierid',
		'pp_date',
		'pp_branch',
        'cm_description',
		'pp_note',
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
			'template' => '{PObyRE}',
			
			'buttons' => array(
                   'PObyRE' => array(
                    'label'=>'PO Create by RE ',     // text label of the button
                    'url'=>'Yii::app()->createUrl("requisitionhd/PoCreatebyRe/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/create.png', 
        			'visible' => '$data->pp_status=="Open"',
					),
             
        	),
		),
	),
)); ?>
