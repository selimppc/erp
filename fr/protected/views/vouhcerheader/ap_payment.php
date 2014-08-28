<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Account Payable'=>array('vouhcerheader/appayment'),
	'New  Account Payable',
);

$this->menu=array(
	array('label'=>'Manage Account Payable', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('vouhcerheader/appayment')),
);
?>

<style type="text/css">
	table .money-receipt-sales, td, th
	{
		border: 1px solid #4E8EC2;
	}

</style>

<h1>Account Payable List </h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grndetail-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'suppliercode',
		array(
					'class'=>'CLinkColumn',
                    'header'=>'Supplier Code',
                    'labelExpression'=>'$data->suppliercode',
					'urlExpression'=>'array("vouhcerheader/appaymentvoucher", "suppliercode"=>$data->suppliercode, "suppliername"=>$data->suppliername, "accoutcode"=>$data->accoutcode )',
                    ),
		'suppliername',
		'accoutcode',
		'conperson',
		'payableamt',

	),
)); ?>
