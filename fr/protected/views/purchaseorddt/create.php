<?php
/* @var $this PurchaseorddtController */
/* @var $model Purchaseorddt */

$this->breadcrumbs=array(
	'Purchase'=>array('purchaseordhd/admin'),
	'New Purchase Order Detail',
);

$this->menu=array(
	//array('label'=>'List Purchase Order Details', 'url'=>array('index')),
	array('label'=>'Manage Purchase Order Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('PurchaseOrderNumberS1', 'pp_purordnum'=>$pp_purordnum, 'pp_status'=>$pp_status )),
);
?>

<div style="width: 100%; float: left;">
	<div style="width: 46%; float: left; padding-right: 1%;">
		<h1>New Purchase Order Details</h1>

		<?php $this->renderPartial('_form', array('model'=>$model)); ?>

	</div>
	
	<div style="width: 48%; float: left;">
		Purchase Order Detail # <?php echo $pp_purordnum; ?>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'class-grid',
		'dataProvider'=>Purchaseorddt::model()->searchDetail($pp_purordnum),
		//'filter'=>$result,
	
		'columns'=>array(
			//'id',
			'pp_purordnum',
			'cm_code',
			 array(            
		            'name'=>'Product Description',
		            'value'=>'CHtml::encode($data->cm_name)',
		        ),
			'pp_quantity',
			//'pp_grnqty',
			'pp_unit',
			'pp_unitqty',
			'pp_purchasrate',
			//array('name'=>"status",'value'=>'$data->pp_status'),
	    	
		
		))); ?>
		
	</div>
</div>





