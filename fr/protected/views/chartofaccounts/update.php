<?php
/* @var $this ChartofaccountsController */
/* @var $model Chartofaccounts */

$this->breadcrumbs=array(
	'Chart of Accounts'=>array('admin'),
	$model->am_accountcode=>array('view','id'=>$model->am_accountcode),
	'Update Chart of Accounts',
);

$this->menu=array(
	//array('label'=>'List Chartofaccounts', 'url'=>array('index')),
	array('label'=>'Create Chart of Accounts', 'url'=>array('create')),
	array('label'=>'View Chart of Accounts', 'url'=>array('view', 'id'=>$model->am_accountcode)),
	array('label'=>'Manage Chart of Accounts', 'url'=>array('admin')),
);
?>

<h1>Update Chart of Accounts <?php echo $model->am_accountcode; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>