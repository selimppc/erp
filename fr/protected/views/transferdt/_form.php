<?php
/* @var $this TransferdtController */
/* @var $model Transferdt */
/* @var $form CActiveForm */
?>


<div style="width: 100%; float: left;">

<div style="width: 48%; float: left;">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transferdt-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'cm_code'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php // echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'im_transfernum'); ?>
		<?php echo $form->textField($model,'im_transfernum',array('readonly'=>true )); ?>
		<?php echo $form->error($model,'im_transfernum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cm_code'); ?>
		<?php // echo $form->textField($model,'cm_code',array('size'=>50,'maxlength'=>50)); ?>
		
		<?php 
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'name'=>'cm_code',
				'model'=>$model,
				'attribute'=>'cm_code',
				'source'=>CController::createUrl('/Transferdt/GetCmNames'),
				'options'=>array(
					'minLength'=>'1', 
					'select'=>'js:function(event, ui){
						$("#cm_code").text(ui.item.value);
						$("#productname").text(ui.item.label);
						$("#cm-sktunit").val(ui.item.unit);
						$("#available_quantity").text(ui.item.available);
						
					}'
				),
				'htmlOptions'=>array(
					'id'=>'cm_code',
					//'rel'=>'val',
					'placeholder'=>'search by product name',
				),
			));
		?> <div id="productname"></div>

		<?php echo $form->error($model,'cm_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'im_unit'); ?>
		<?php echo $form->textField($model,'im_unit',array('id'=>'cm-sktunit', 'readonly'=>TRUE)); ?>
		<?php echo $form->error($model,'im_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'im_quantity'); ?>
		<?php echo $form->textField($model,'im_quantity', array('placeholder'=>'type transfer quantity')); ?>
		<?php echo $form->error($model,'im_quantity'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'im_rate'); ?>
		<?php echo $form->hiddenField($model,'im_rate', array('placeholder'=>'type rate')); ?>
		<?php //echo $form->error($model,'im_rate'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'inserttime'); ?>
		<?php echo $form->hiddenField($model,'inserttime'); ?>
		<?php //echo $form->error($model,'inserttime'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updatetime'); ?>
		<?php echo $form->hiddenField($model,'updatetime'); ?>
		<?php //echo $form->error($model,'updatetime'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'insertuser'); ?>
		<?php echo $form->hiddenField($model,'insertuser',array('size'=>50,'maxlength'=>50)); ?>
		<?php //echo $form->error($model,'insertuser'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updateuser'); ?>
		<?php echo $form->hiddenField($model,'updateuser',array('size'=>50,'maxlength'=>50)); ?>
		<?php //echo $form->error($model,'updateuser'); ?>
	</div>

	<div class="row buttons">
		<div class="row status-container">
            <div class="span4 action-bar">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class'=>'action-btn', 'id'=>'action-btn-1')); ?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>



<div style="width: 48%; float: left; margin-left: 2%;">


<h3> Product Information: </h3> <br>


<p>
Product Code: <span id="product_code"></span> <br>
Store: <span id="store_id"></span> <br>
Available: <span id="available_quantity"></span> <br>

</p>


</div>
</div>

