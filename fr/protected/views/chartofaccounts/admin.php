<?php
/* @var $this ChartofaccountsController */
/* @var $model Chartofaccounts */

$this->breadcrumbs=array(
	'Chart of Accounts'=>array('admin'),
	'Manage Chart of Accounts',
);

$this->menu=array(
	//array('label'=>'List Chartofaccounts', 'url'=>array('index')),
	array('label'=>'New Chart of Accounts', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('groupone/admin')),
				array('label'=>'Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('grouptwo/admin')),
				array('label'=>'Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('groupthree/admin')),
				array('label'=>'Default', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('amdefault/admin')),
	),
	),
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#chartofaccounts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Chart of Accounts</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chartofaccounts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'am_accountcode',
		'am_description',
		'am_accounttype',
		'am_accountusage',
		'am_groupone',
		'am_grouptwo',
		
		'am_groupthree',
		'am_groupfour',
		'am_analyticalcode',
		//'am_branch',
		'am_status',
		//'inserttime',
		//'updatetime',
		//'insertuser',
		//'updateuser',
	
		array(
			'class'=>'CButtonColumn',
			'header'=>'Action',
		),
	),
)); ?>
