<div class="form" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php // echo $form->errorSummary(array($model,$profile)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username', array('class' => 'input-form-label')); ?>
		<?php echo $form->textField($model,'username', array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password', array('class' => 'input-form-label')); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'repeatpassword', array('class' => 'input-form-label')); ?>
		<?php echo $form->passwordField($model,'repeatpassword',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'repeatpassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email', array('class' => 'input-form-label')); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        
    <div class="row">
		<?php echo $form->labelEx($model,'employeeid', array('class' => 'input-form-label')); ?>
		<?php echo $form->textField($model,'employeeid',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'employeeid'); ?>
	</div>
 
	<div class="row">
		<?php echo $form->labelEx($model,'employeebranch', array('class' => 'input-form-label')); ?>
		<?php echo $form->textField($model,'employeebranch',array('size'=>60, 'maxlength'=>128)); ?>
		<?php echo $form->error($model,'employeebranch'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'user_type', array('class' => 'input-form-label')); ?>
        <?php echo $form->dropDownList($model,'user_type',array('Admin'=>'Admin', 'Sales'=>'Sales')); ?>
        <?php echo $form->error($model,'user_type'); ?>
    </div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'superuser', array('class' => 'input-form-label')); ?>
		<?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
		<?php echo $form->error($model,'superuser'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status', array('class' => 'input-form-label')); ?>
		<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
		<?php echo $form->labelEx($profile,$field->varname, array('class' => 'input-form-label')); ?>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>
			<?php
			}
		}
?>
	<div class="row buttons">
            <div class="row status-container">
                <div class="span4 action-bar">
                    <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class'=>'action-btn', 'id'=>'action-btn-1')); ?>
                </div>
            </div>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->