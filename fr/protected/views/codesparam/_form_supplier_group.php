<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'client-account-create-form',
    'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'cm_code'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php // echo $form->errorSummary($model); ?>
	
    <div class="row">
        <?php echo $form->labelEx($model,'cm_type'); ?>
        <?php echo $form->textField($model,'cm_type', array('value'=>'Supplier Group', 'readonly' => 'true')); ?>
        <?php echo $form->error($model,'cm_type'); ?>
    </div>
	
	
    <div class="row">
        <?php echo $form->labelEx($model,'cm_code'); ?>
        <?php echo $form->textField($model,'cm_code', array('style' => 'text-transform: uppercase')); ?>
        <?php echo $form->error($model,'cm_code'); ?>
    </div>
	
	
		
    <div class="row">
        <?php echo $form->labelEx($model,'cm_desc'); ?>
        <?php echo $form->textField($model,'cm_desc'); ?>
        <?php echo $form->error($model,'cm_desc'); ?>
    </div>
    
	<div class="row">
        <?php echo $form->labelEx($model,'cm_branch'); ?>
        <?php echo $form->dropDownList($model,'cm_branch', CHtml::listData(Branchmaster::model()->findAll(),'cm_branch','cm_branch')); ?>
        <?php echo $form->error($model,'cm_branch'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'cm_acccode'); ?>
        <?php //echo $form->textField($model,'cm_acccode'); ?>
        <?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'cm_acccode',
						'model'=>$model,
						'attribute'=>'cm_acccode',
						'source'=>CController::createUrl('/codesparam/getaccountcode'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#cm_acccode").val(ui.item.value);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'cm_acccode',
							//'rel'=>'val',
							'placeholder'=>'search account code..',
						),
					));
				?> 
        <?php echo $form->error($model,'cm_acccode'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'cm_acctax'); ?>
        <?php //echo $form->textField($model,'cm_acctax'); ?>
        <?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'cm_acctax',
						'model'=>$model,
						'attribute'=>'cm_acctax',
						'source'=>CController::createUrl('/codesparam/getaccountcode'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#cm_acctax").val(ui.item.value);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'cm_acctax',
							//'rel'=>'val',
							'placeholder'=>'search tax account..',
						),
					));
				?> 
        <?php echo $form->error($model,'cm_acctax'); ?>
    </div>
    

	
	
    <div class="row">
        <?php echo $form->labelEx($model,'cm_active'); ?>
        <?php echo $form->dropDownList($model,'cm_active', $this->getActiveOptions()); ?>
        <?php echo $form->error($model,'cm_active'); ?>
    </div>
	
	
    <div class="row">
        <?php // echo $form->labelEx($model,'inserttime'); ?>
        <?php echo $form->hiddenField($model,'inserttime'); ?>
        <?php // echo $form->error($model,'inserttime'); ?>
    </div>
	
	
    <div class="row">
        <?php // echo $form->labelEx($model,'updatetime'); ?>
        <?php echo $form->hiddenField($model,'updatetime'); ?>
        <?php // echo $form->error($model,'updatetime'); ?>
    </div>
	
	
    <div class="row">
        <?php // echo $form->labelEx($model,'insertuser'); ?>
        <?php echo $form->hiddenField($model,'insertuser'); ?>
        <?php // echo $form->error($model,'insertuser'); ?>
    </div>
	
	
    <div class="row">
        <?php // echo $form->labelEx($model,'updateuser'); ?>
        <?php echo $form->hiddenField($model,'updateuser'); ?>
        <?php // echo $form->error($model,'updateuser'); ?>
    </div>
	
    <div class="row buttons">
    	<div class="row status-container">
                <div class="span4 action-bar">
        			<?php echo CHtml::submitButton('Submit', array('class'=>'action-btn', 'id'=>'action-btn-1')); ?>
        		</div>
		</div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form --> 
