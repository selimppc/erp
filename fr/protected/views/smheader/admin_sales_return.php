<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Sales Return'=>array('smheader/adminsalesreturn'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Sales Return',  'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('smheader/adminmanagesalesreturn')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Sales Return No', 'url'=>array('transaction/managesalesreturnno')),
	),
	),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sm-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>New Sales Return</h1>
<p style="font-style: italic; color: #666;"> please click appropiate invoice number</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sm-header-grid',
	'dataProvider'=>$model->searchReturn(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'sm_number',
		array(
					'class'=>'CLinkColumn',
                    'header'=>'Sales Number',
                    'labelExpression'=>'$data->sm_number',
                    'urlExpression'=>'array("smheader/createsalesreturn","sm_number"=>$data->sm_number)',
                    ),
		'sm_date',
		'cm_cuscode', //with customer name
		'sm_sp',
		//'sm_doc_type',
		//'sm_territory',
		//'sm_rsm',
		//'sm_area',
		'sm_payterms',
		'sm_totalamt',
		'sm_total_tax_amt',
		//'sm_disc_rate',
		'sm_disc_amt',
		'sm_netamt',
		//'sm_sign',
		'sm_stataus',
		//'sm_refe_code',
		//'inserttime',
		//'updatetime',
		//'insertuser',
		//'updateuser',
		

	),
)); ?>
