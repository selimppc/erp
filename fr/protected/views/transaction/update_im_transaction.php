<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Recieve Stock'=>array('imtransaction/admin'),
	'Update IM Transaction',
);


$this->menu=array(
	array('label'=>'Manage IM Transaction', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/ManageImTrn')),
); 
?>

<h1>Update IM Transaction</h1>

<?php echo $this->renderPartial('_from_im_trn', array('model'=>$model)); ?>
