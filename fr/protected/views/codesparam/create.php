<?php
$this->breadcrumbs=array(
	'Codes Param'=>array('admin'),
	'New Codes Param',
);

$this->menu=array(
	//array('label'=>'List Codesparams', 'url'=>array('index')),
    array('label'=>'Manage Codes Param', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),

);
?>

<h1>New Codes Param</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
