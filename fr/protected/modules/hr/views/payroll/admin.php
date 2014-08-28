<?php
/* @var $this PayrollController */

$this->breadcrumbs=array(
	'Paie'=>array('admin'),
	'Gestion de la paie',
);

$this->menu=array(
	array('label'=>'Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('trnheader/admin')),
    
		array('label'=>'Parametres', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'HR Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('payroll/ManageHrTransaction')),
				array('label'=>'HR Defaut', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('payroll/ManageHrDefault')),
	),
	),
);
?>

<h1><?php // echo $this->id . '/' . $this->action->id; ?></h1>

<h1 style="font-size: 30px;"> Bienvenue au système de gestion de la paie </h1>


