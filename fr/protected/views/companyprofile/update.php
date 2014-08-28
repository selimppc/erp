<?php
/* @var $this CompanyprofileController */
/* @var $model Companyprofile */

$this->breadcrumbs=array(
	'Company Profile'=>array('view', 'id'=>$model->id),
	//$model->title=>array('view','id'=>$model->id),
	'Update Company Profile',
);

$this->menu=array(
	//array('label'=>'List Company Profiles', 'url'=>array('index')),
	//array('label'=>'Create Company Profiles', 'url'=>array('create')),
	array('label'=>'View Company Profile', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Company Profiles', 'url'=>array('admin')),
);
?>

<h1>Update Company Profile </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>