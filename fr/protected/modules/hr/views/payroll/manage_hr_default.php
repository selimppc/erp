<?php
$this->breadcrumbs=array(
	'Paie'=>array('admin'),
	'Parametres',
	'HR Default',
);

$this->menu=array(
    array('label'=>'HR Default', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('payroll/ManageHrDefault')),
	);
?>

<h1> HR Default</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'class-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$result,
	
	'columns'=>array(
		'id',
		'pfconrate',
		'othours',
		'otrate', 
		'taxyear',
		'taxoffset',
		
))); ?>

