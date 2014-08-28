<?php
/* @var $this TransferdtController */
/* @var $model Transferdt */

$this->breadcrumbs=array(
	'Transfer'=>array('transferhd/admin'),
	'Transfer Detail',
);

$this->menu=array(
	//array('label'=>'List Transfer Detail', 'url'=>array('index')),
	array('label'=>'New Transfer Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create', 'im_transfernum'=>$im_transfernum)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#transferdt-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Transfer Detail</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'transferdt-grid',
	'dataProvider'=>$model->search($im_transfernum),
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		'im_transfernum',
		'cm_code',
		'im_unit',
		'im_quantity',
		'im_rate',
		/*
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array
            (
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transferdt/update/", 
                                            array("id"=>$data->id, "im_transfernum"=>$data->im_transfernum
											))',
                ),

            ),
		),
	),
)); ?>
