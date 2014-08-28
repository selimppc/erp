<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'GRN'=>array('purchaseordhd/ViewPurchaseOrderHd'),
	'Manage GRN'=>array('purchaseordhd/ViewGrn'),
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	//array('label'=>'Create Grndetail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create', 'vGrnNumber'=>$im_grnnumber, 'pp_purordnum'=>$im_purordnum,)),
);


?>


<h1>GRN Details</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grndetail-grid',
	'dataProvider'=>$model->search($im_grnnumber),
	'filter'=>$model,
	'columns'=>array(

		'im_grnnumber',
		'cm_code',
		'cm_name',
		'im_BatchNumber',
		'im_ExpireDate',
		'im_RcvQuantity',
		'im_costprice',
		'im_unit',
		'im_unitqty',
		'im_rowamount',

	
	),
)); ?>
