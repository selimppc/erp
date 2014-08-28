<?php
/* @var $this CompanyprofileController */
/* @var $model Companyprofile */

$this->breadcrumbs=array(
	'Company Profile'=>array('admin'),
	'New Company Profile',
);

$this->menu=array(
	//array('label'=>'List Company Profiles', 'url'=>array('index')),
	array('label'=>'Manage Company Profiles', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>New Company Profile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>