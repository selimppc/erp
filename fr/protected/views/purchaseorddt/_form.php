<?php
/* @var $this PurchaseorddtController */
/* @var $model Purchaseorddt */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchaseorddt-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'cm_code'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php // echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_purordnum'); ?>
		<?php echo $form->textField($model,'pp_purordnum', array('readonly' => 'true') ); ?>
		
		<?php echo $form->error($model,'pp_purordnum'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'cm_code'); ?>
		<?php 
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'name'=>'cm_code',
				'model'=>$model,
				'attribute'=>'cm_code',
				'source'=>CController::createUrl('/purchaseorddt/CodeQuantityUnit'),
				'options'=>array(
					'minLength'=>'1', 
					'select'=>'js:function(event, ui){
						$("#cm_code").text(ui.item.value);
						$("#product_name_id").text(ui.item.label);
						$("#unitmeasure").text(ui.item.unit);
					}'
				),
				'htmlOptions'=>array(
					'id'=>'cm_code',
					//'rel'=>'val',
					'placeholder'=>'search by product name'
				),
			));
		?>  
		<?php echo $form->error($model,'cm_code'); ?>
	</div>
	
	<div class="row" style="margin-bottom: 10px">
		Product Description: 
		<span id="product_name_id" style="margin-left: 20px; font-size: 14px; background: #E9E9E9;"></span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_quantity'); ?>
		<?php echo $form->textField($model,'pp_quantity'); ?>
		<?php echo $form->error($model,'pp_quantity'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'pp_grnqty'); ?>
		<?php //echo $form->textField($model,'pp_grnqty'); ?>
		<?php //echo $form->error($model,'pp_grnqty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_unit'); ?>
		<?php echo $form->dropDownList($model,'pp_unit', CHtml::listData(Codesparam::model()->findAll('cm_type = "Unit Of Measurement" '), 'cm_code', 'cm_code')); ?>  
		<?php echo $form->error($model,'pp_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_unitqty'); ?>
		<?php  echo $form->textField($model,'pp_unitqty'); ?>
		<?php echo $form->error($model,'pp_unitqty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_purchasrate'); ?>
		<?php echo $form->textField($model,'pp_purchasrate'); ?>
		<?php echo $form->error($model,'pp_purchasrate'); ?>
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