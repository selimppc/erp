<?php
/* @var $this CompanyprofileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Company Profile',
);

$this->menu=array(
	array('label'=>'New Company Profiles', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Manage Company Profiles', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<h1>Company Profile</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
