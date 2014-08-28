<?php
$this->breadcrumbs=array(
	'Voucher Header'=>array('vouhcerheader/admin'),
	'Voucher Number',
);

$this->menu=array(
	array('label'=>'New Voucher Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/createvoucherno')),
    array('label'=>'Manage Voucher Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/managevoucherno')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Voucher Number', 'url'=>array('transaction/createvoucherno')),
	),
	),
);
?>

<h1> Manage Voucher Number</h1>


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
                    'Yii::app()->createUrl("transaction/UpdateVoucherNo/", 
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

