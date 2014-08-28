<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Transactions'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Transactions', 'url'=>array('index')),
	array('label'=>'New Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('transactiongrid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Requisition Number</h1>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transactiongrid',
    'dataProvider'=>$model->search(),
    //'filter'=>$model,
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
                    'Yii::app()->createUrl("transaction/view/", 
                                            array("cm_type"=>$data->cm_type, "cm_trncode"=>$data->cm_trncode
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/update/", 
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
    ),
)); ?>
