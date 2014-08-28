<?php
/* @var $this ProductmasterController */
/* @var $model Productmaster */

$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'Manage GRN',
);

$this->menu=array(
	//array('label'=>'List Productmaster', 'url'=>array('index')),
	array('label'=>'GRN', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/grn_a.png" /></span>{menu}', 'url'=>array('purchaseordhd/ViewPurchaseOrderHd')),
	array('label'=>'Manage GRN', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('purchaseordhd/ViewGrn')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'GRN Number', 'url'=>array('transaction/ManageGRNnumnber')),

	),
	),
);



?>




<h1> New GRN from Purchase Order</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	
	'columns'=>array(
		//'im_grnnumber',
		array(
			'class'=>'CLinkColumn',
            'header'=>'GRN Number',
            'labelExpression'=>'$data->im_grnnumber',
            //'urlExpression'=>'Yii::app()->createUrl("Purchaseorddt/PurchaseOrderNumberS1", array("pp_purordnum"=>$data->pp_purordnum))',
			//'urlExpression'=>'array("grndetail/create", "pp_purordnum"=>$data->im_purordnum, "vGrnNumber"=>$data->im_grnnumber )',
			'urlExpression'=>'$data->im_status=="Open" ? array("grndetail/create", "pp_purordnum"=>$data->im_purordnum, "vGrnNumber"=>$data->im_grnnumber ) : array("grndetail/grnDetailAdmin", "im_grnnumber"=>$data->im_grnnumber) ',
			//'urlExpression'=>'array("grndetail/admin","im_grnnumber"=>$data->im_grnnumber, "im_purordnum"=>$data->im_purordnum )',
			//'linkHtmlOptions'=>array('target'=>'_blank'),  
        ),
		'im_purordnum',
		'im_date',
		'cm_supplierid',
		'im_status',
        
         array(
            'class'=>'CButtonColumn',
         	'header' => 'Action',
			'template' => '{GRN}',
			
			'buttons' => array(
                   'GRN' => array(
                    'label'=>'Confirm GRN',     // text label of the button
                    'url'=>'Yii::app()->createUrl("purchaseordhd/ConfirmGRN/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/create.png', 
        			'visible' => '$data->im_status=="Approved" OR $data->im_status=="Open"',
					),
             
        	),
	),

))); ?>
