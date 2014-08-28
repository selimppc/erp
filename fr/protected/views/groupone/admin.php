<?php
/* @var $this GrouponeController */
/* @var $model Groupone */

$this->breadcrumbs=array(
		'Chart of Accounts'=>array('chartofaccounts/admin'),
		'Settings',
		'Group One',
);

$this->menu=array(
	array('label'=>'New Group One', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#groupone-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Group One</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'groupone-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'am_groupone',
		'am_description',

	),
)); ?>
