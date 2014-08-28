<?php
$this->breadcrumbs=array(
	'Paie'=>array('admin'),
	'Parametres',
	'HR Transaction',
);

$this->menu=array(

    array('label'=>'Gerer HR Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/managevoucherno')),
		array('label'=>'Parametres', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'HR Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/createvoucherno')),
	),
	),
);
?>

<h1>Nouveau HR Transaction </h1>
<?php echo $this->renderPartial('_from_hr_transaction', array('model'=>$model)); ?>
