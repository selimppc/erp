<?php
/* @var $this AmdefaultController */
/* @var $model Amdefault */

$this->breadcrumbs=array(
		'Chart of Accounts'=>array('chartofaccounts/admin'),
		'Settings',
		'Defaults',
);

$this->menu=array(
	
	//array('label'=>'New Am Default', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#amdefault-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Defaults</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'amdefault-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'am_offset',
		'am_pnlacount',
		'am_year',
		'am_period',

		//array(
			//'class'=>'CButtonColumn',
		//),
	),
)); ?>
