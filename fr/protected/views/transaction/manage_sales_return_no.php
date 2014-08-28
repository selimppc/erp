<?php
$this->breadcrumbs=array(
	'Sales Return'=>array('smheader/adminsalesreturn'),
	'Sales Return Number',
);

$this->menu=array(
	array('label'=>'New Sales Return Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateSalesReturnNo')),
    array('label'=>'Manage Sales Return Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageSalesReturnNo')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Sales Return Number', 'url'=>array('transaction/CreateSalesReturnNo')),
	),
	),
);
?>

<h1> Manage Sales Return Number</h1>


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
			'header'=>'Action',
            'template'=>'{update}{delete}',
            'buttons'=>array
            (

                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/UpdateSalesReturnNo/", 
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

