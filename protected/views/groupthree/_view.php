<?php
/* @var $this GroupthreeController */
/* @var $data Groupthree */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('am_groupone')); ?>:</b>
	<?php echo CHtml::encode($data->am_groupone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('am_grouptwo')); ?>:</b>
	<?php echo CHtml::encode($data->am_grouptwo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('am_groupthree')); ?>:</b>
	<?php echo CHtml::encode($data->am_groupthree); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('am_description')); ?>:</b>
	<?php echo CHtml::encode($data->am_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inserttime')); ?>:</b>
	<?php echo CHtml::encode($data->inserttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatetime')); ?>:</b>
	<?php echo CHtml::encode($data->updatetime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('insertuser')); ?>:</b>
	<?php echo CHtml::encode($data->insertuser); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updateuser')); ?>:</b>
	<?php echo CHtml::encode($data->updateuser); ?>
	<br />

	*/ ?>

</div>