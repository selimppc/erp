<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Account Payable'=>array('apinvoice'),
	'Invoice',
);

$this->menu=array(
	array('label'=>'Manage A/P Invoice', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('apinvoice')),
);
?>

<style type="text/css">
	table .money-receipt-sales, td, th
	{
		border: 1px solid #4E8EC2;
	}

</style>

<h1>GRN List for Create Invoice</h1>



<table style="width: 100%; float: left;">
	<tr> 
		<td style="text-align: center; background: #4085BB; color: white;"> 
			GRN List for Create Invoice
		</td>
	</tr>
</table>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grndetail-grid',
	'dataProvider'=>Grnheader::model()->searchInvoice(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'im_grnnumber',
		'cm_supplierid',
		'im_date',
		'pp_requisitionno',
		'im_payterms',
		'im_amount',
		'im_netamt',
		'im_status',

		array(
		'class'=>'CButtonColumn',
		'template'=>'{create}',
		'header'=>'Action',
		'buttons'=>array
            (
				'create' => array
				(
					'label'=>'Create Invoice', 
					'url'=>'Yii::app()->createUrl("vouhcerheader/CreateInvoice/", array("id"=>$data->id))',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/create.png', 
					//'visible' => '$data->pp_status=="Open" OR $data->pp_status=="P-Recieved"',
				), 
			)
		)
	),
)); ?>
