<?php
$this->breadcrumbs=array(
	'Branch Master'=>array('branchmaster/admin'),
	'Settings >> New Branch Currency',
);

$this->menu=array(
	array('label'=>'New Branch Currency', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('codesparam/CreateBranchCurrency')),
    array('label'=>'Manage Branch Currency', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('branchmaster/BranchCurrency')),
		array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Currency', 'url'=>array('branchmaster/BranchCurrency')),
	),
	),
);
?>

<h1>New Unit Of Measurement</h1>
<?php echo $this->renderPartial('_form_branch_currency', array('model'=>$model)); ?>
