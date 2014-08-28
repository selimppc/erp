<?php
/* @var $this TransferhdController */
/* @var $model Transferhd */

$this->breadcrumbs=array(
	'Transfer'=>array('admin'),
	'Manage Transfer Header',
);

$this->menu=array(
	//array('label'=>'List Transfer Header', 'url'=>array('index')),
	array('label'=>'New Transfer Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'IM Transfer Number', 'url'=>array('transaction/ManageImTranNum')),
	),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transferhd-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transfer Header</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferhd-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'im_transfernum',
				array(
					'class'=>'CLinkColumn',
                    'header'=>'Transfer Number',
                    'labelExpression'=>'$data->im_transfernum',
                    'urlExpression'=>'array("transferdt/TransferNumber","im_transfernum"=>$data->im_transfernum, "im_status"=>$data->im_status)',
                    ),
		'im_date',
		'im_condate',
		// 'im_note',
		'im_fromstore',
		'im_tostore',
		'im_status',

		array(
			'class'=>'CButtonColumn',
			'header'=>'Action',
			'deleteConfirmation'=>"js:'Do you really want to delete this record ?'",
			'template'=>'{view}{update}{delete}{confirm}',
			'buttons'=>array
			(
				'update' => array
				(
					'label'=>'update',
					'visible'=>'$data->im_status=="Open"',
					//'options'=>array('onclick'=>$model->id),
				),   
				
				'delete' => array
				(
					'label'=>'delete',
					'visible'=>'$data->im_status=="Open"',
					//'options'=>array('onclick'=>$model->id),
				),  
				
				'confirm' => array(
                    'label'=>'Confirm',     // text label of the button
                    'url'=>'Yii::app()->createUrl("transferhd/ConfirmStatus/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->im_status=="Open" ',
				),
					
			),
		),
	),
)); ?>
