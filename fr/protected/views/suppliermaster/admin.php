<?php
/* @var $this SuppliermasterController */
/* @var $model Suppliermaster */

$this->breadcrumbs=array(
	'Supplier Masters'=>array('admin'),
	'Manage Supplier',
);

$this->menu=array(
	//array('label'=>'List Supplier Master', 'url'=>array('index')),
	array('label'=>'New Supplier Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Supplier Group Manage', 'url'=>array('suppliermaster/SupplierGroup')),
	),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#suppliermaster-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Supplier</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'suppliermaster-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'cm_supplierid',
		'cm_group',
		'cm_orgname',
		//'cm_address',
		//'cm_district',
		//'cm_post',
		
		//'cm_policest',
		//'cm_postcode',
		//'cm_contactperson',
		//'cm_phone',
		'cm_cellphone',
		//'cm_fax',
		'cm_email',
		//'cm_url',
		'cm_status',
		//'inserttime',
		//'updatetime',
		//'insertuser',
		//'updateuser',
		
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
                'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("suppliermaster/view/", 
                                            array("cm_supplierid"=>$data->cm_supplierid, 
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("suppliermaster/update/", 
                                            array("cm_supplierid"=>$data->cm_supplierid,
											))',
                ),
                'delete'=> array
                (
                    'url'=>
                    'Yii::app()->createUrl("suppliermaster/delete/", 
                                            array("cm_supplierid"=>$data->cm_supplierid,
											))',
                ),
            ),
		),
	),
)); ?>
