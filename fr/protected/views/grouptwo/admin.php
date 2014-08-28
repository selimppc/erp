<?php
/* @var $this GrouptwoController */
/* @var $model Grouptwo */

$this->breadcrumbs=array(
	'Chart of Accounts'=>array('chartofaccounts/admin'),
	'Settings',
	'Group Two',
);

$this->menu=array(
	//array('label'=>'List Group Two', 'url'=>array('index')),
	//array('label'=>'New Group Two', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#grouptwo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Group Two</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grouptwo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'am_groupone',
		'am_grouptwo',
		'am_description',

	),
)); ?>
