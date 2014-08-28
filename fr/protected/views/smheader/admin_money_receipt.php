<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Money Receipt'=>array('smheader/adminmoneyreceipt'),
	'Post To GL',
);

$this->menu=array(
	array('label'=>'Manage Money Receipt', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('smheader/adminmoneyreceipt')),
	array('label'=>'Post to GL', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/post_gl_a.png" /></span>{menu}', 'url'=>array('smheader/mrPostToGl')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Money Receipt No', 'url'=>array('transaction/managemoneyreceiptno')),
	),
	),
);

?>

<h1>Manage Money Receipt</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sm-header-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'cm_code',	
		array(
				'class'=>'CLinkColumn',
                'header'=>'Customer Code',
                'labelExpression'=>'$data->cm_code',
                'urlExpression'=>'array("smheader/createmoneyreceipt","cm_code"=>$data->cm_code, "cm_name"=>$data->cm_name)',
                ),
		'cm_name',	
		'cm_group',	
		'cm_address',	
		'cm_cellnumber',	
		'sm_receivable',
	),
)); ?>
