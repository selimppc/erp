<?php
/* @var $this VouhcerheaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Voucher Header',
);

$this->menu=array(
	array('label'=>'Create Voucher Header', 'url'=>array('create')),
	array('label'=>'Manage Voucher Header', 'url'=>array('admin')),
);
?>

<h1>Voucher Header</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
