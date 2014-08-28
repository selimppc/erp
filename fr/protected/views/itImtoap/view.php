<?php
/* @var $this ItImtoapController */
/* @var $model ItImtoap */

$this->breadcrumbs=array(
	'Module Interface'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Module Interface', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Update Module Interface', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/update_a.png" /></span>{menu}', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Module Interface', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/delete_a.png" /></span>{menu}', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItImModule Interfacetoap', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>View Module Interface # <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_group',
		'sup_group',
		'debit_account',
		'credit_account',
		'active',
		'inserttime',
		'updatetime',
		'insertuser',
		'updateuser',
	),
)); ?>
