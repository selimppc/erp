<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Delivery Order'=>array('smheader/deliveryOrder'),

);

?>

<h1>Manage Invoice</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sm-header-grid',
	'dataProvider'=>$model->deliveryOrder(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'sm_number',
			array(
					'class'=>'CLinkColumn',
                    'header'=>'Sales Number',
                    'labelExpression'=>'$data->sm_number',
                    'urlExpression'=>'array("batchsale/admin","sm_number"=>$data->sm_number)',
                ),
		'sm_date',
		'cm_cuscode',
		'sm_sp',
		//'sm_doc_type',
		//'sm_territory',
		//'sm_rsm',
		//'sm_area',
		'sm_payterms',
		'sm_totalamt',
		'sm_total_tax_amt',
		//'sm_disc_rate',
		'sm_disc_amt',
		'sm_netamt',
		//'sm_sign',
		'sm_stataus',
		//'sm_refe_code',

		array(
            'class'=>'CButtonColumn',
			'header'=>'Action',
            'template'=>'{confirm}',
            'buttons'=>array
            (
            	/*
            	'update'=> array
                (
                    'label'=>'update',     // text label of the button
                    //'url'=>'Yii::app()->createUrl("smheader/ApproveStatus/", array("id"=>$data->id))', 
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open" OR $data->sm_stataus=="Delivered"',
                ),
                'delete'=> array
                (
                    'label'=>'delete',     // text label of the button
                    //'url'=>'Yii::app()->createUrl("smheader/ApproveStatus/", array("id"=>$data->id))', 
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open" OR $data->sm_stataus=="Delivered"',
                ), */
                'confirm'=> array
                (
                    'label'=>'Confirm',     // text label of the button
                    'url'=>'Yii::app()->createUrl("smheader/OrdDeliverd/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open" OR $data->sm_stataus=="Confirmed"',
                ),
            ),
        ),
	),
)); ?>
