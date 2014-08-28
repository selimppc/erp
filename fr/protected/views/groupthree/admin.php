<?php
/* @var $this GroupthreeController */
/* @var $model Groupthree */

$this->breadcrumbs=array(
		'Chart of Accounts'=>array('chartofaccounts/admin'),
		'Settings',
		'Group Three',
);

$this->menu=array(
	//array('label'=>'New Group Three', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#groupthree-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Group Three</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'groupthree-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'am_groupone',
		'am_grouptwo',
		'am_groupthree',
		'am_description',

	),
)); ?>
