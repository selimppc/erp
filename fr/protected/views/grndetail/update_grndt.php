<?php
/* @var $this GrndetailController */
/* @var $model Grndetail */

$this->breadcrumbs=array(
	'Manage GRN'=>array('purchaseordhd/ViewGrn'),
	'Manage GRN Detail'=>array('admin', 'im_grnnumber'=>$im_grnnumber,),
	'Update GRN Detail',
);

$this->menu=array(
	//array('label'=>'List Grndetail', 'url'=>array('index')),
	//array('label'=>'Create Grndetail', 'url'=>array('create')),
	//array('label'=>'View Grndetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GRN Detail', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin', 'im_grnnumber'=>$im_grnnumber,  )),
);
?>

<h1>Update GRN Detail <?php echo $im_grnnumber; ?></h1>

<?php $this->renderPartial('_form_update_grndt', array('model'=>$model, 'cm_code'=>$cm_code,)); ?>