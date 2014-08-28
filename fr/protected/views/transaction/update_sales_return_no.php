<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Sales Return'=>array('smheader/adminsalesreturn'),
	'Update Sales Return No',
);


$this->menu=array(
	array('label'=>'Manage Sales Return No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageSalesReturnNo')),
); 
?>

<h1>Update Sales Return No</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
