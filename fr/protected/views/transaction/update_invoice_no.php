<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Invoice'=>array('smheader/admin'),
	'Update Invoice No',
);


$this->menu=array(
	array('label'=>'Manage Invoice No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/manageinvoiceno')),
); 
?>

<h1>Update Invoice No</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
