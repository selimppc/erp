<?php
$this->breadcrumbs=array(
	'Recieve Stock'=>array('imtransaction/admin'),
	'IM Transaction',
);

$this->menu=array(
	array('label'=>'New IM Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateImTrn')),
    array('label'=>'Manage IM Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageImTrn')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'IM Transaction', 'url'=>array('transaction/CreateImTrn')),
	),
	),
);
?>

<h1> Manage IM Transaction</h1>


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
                    'Yii::app()->createUrl("transaction/UpdateIMTransaction/", 
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

