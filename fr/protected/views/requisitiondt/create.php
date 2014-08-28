<?php
/* @var $this RequisitiondtController */
/* @var $model Requisitiondt */

$this->breadcrumbs=array(
	'Requisition'=>array('requisitionhd/admin'),
	'New Requisition Entry Detail',
);

$this->menu=array(
	//array('label'=>'List Requisition Details', 'url'=>array('index')),
	array('label'=>'Manage Requisition Details', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin', 'pp_requisitionno'=>$pp_requisitionno)),
);
?>


<div style="width: 100%; float: left;">
	<div style="width: 48%; float: left; padding-right: 1%;">
	
		<h1>New Requisition Details</h1>
		
		<?php $this->renderPartial('_form', array('model'=>$model, 'pp_requisitionno'=>$pp_requisitionno,)); ?>

	</div>
	
	<div style="width: 48%; float: left; line-height: 8px;">
		Requisition Entry Detail # <?php echo $pp_requisitionno; ?>
		
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'class-grid',
			'dataProvider'=>Requisitiondt::model()->search($pp_requisitionno),
			//'filter'=>$result,
		
			'columns'=>array(
				'id',
				//'pp_purordnum',
				'cm_code',
				//'cm_name',
					 array(            
				            'name'=>'Product Description',
				            'value'=>'CHtml::encode($data->cm_name)',
				        ),
				'pp_quantity',
				//'pp_grnqty',
				'pp_unit',
				//'pp_unitqty',
				//'pp_purchasrate',
				//array('name'=>"status",'value'=>'$data->pp_status'),
		    	
			
			))); ?>
		
	</div>
</div>
		