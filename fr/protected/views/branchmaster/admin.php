<?php
/* @var $this BranchmasterController */
/* @var $model Branchmaster */

$this->breadcrumbs=array(
	'Branch Masters'=>array('admin'),
	'Manage Branch Master',

);

$this->menu=array(
	//array('label'=>'List Branchmaster', 'url'=>array('index')),
	array('label'=>'New Branch Master', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Currency', 'url'=>array('branchmaster/BranchCurrency')),
		),
		),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#branchmaster-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Branch Master</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'branchmaster-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'cm_branch',
		array(
			'class'=>'CLinkColumn',
            'header'=>'Branch Name',
            'labelExpression'=>'$data->cm_branch',
            //'urlExpression'=>'Yii::app()->createUrl("Purchaseorddt/PurchaseOrderNumberS1", array("pp_purordnum"=>$data->pp_purordnum))',
			'urlExpression'=>'array("branchcurrency/admin","cm_branch"=>$data->cm_branch)',
			//'linkHtmlOptions'=>array('target'=>'_blank'),

            ),
		'cm_currency',
		'cm_description',
		'cm_contacperson',
		'cm_designation',
		'cm_mailingaddress',
		'cm_phone',
		/*
		'cm_cell',
		'cm_fax',
		'active',
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
                    'Yii::app()->createUrl("branchmaster/view/", 
                                            array("cm_branch"=>$data->cm_branch, 
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("branchmaster/update/", 
                                            array("cm_branch"=>$data->cm_branch,
											))',
                ),
                'delete'=> array
                (
                    'url'=>
                    'Yii::app()->createUrl("branchmaster/delete/", 
                                            array("cm_branch"=>$data->cm_branch,
											))',
                ),
            ),
		),
	),
)); ?>
