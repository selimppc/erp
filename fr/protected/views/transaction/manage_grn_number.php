<?php
$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'GRN Number',
);

$this->menu=array(
	array('label'=>'New GRN Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('transaction/CreateGRNnumnber')),
    array('label'=>'Manage GRN Number', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageGRNnumnber')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'GRN Number', 'url'=>array('transaction/ManageGRNnumnber')),
	),
	),
);
?>


<h1> GRN Number</h1>


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
            'template'=>'{update}{delete}',
            'buttons'=>array
            (
  
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("transaction/UpdateGRNNumber/", 
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

