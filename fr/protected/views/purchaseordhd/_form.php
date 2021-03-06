<?php
/* @var $this PurchaseordhdController */
/* @var $model Purchaseordhd */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchaseordhd-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'pp_purordnum'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php // echo $form->errorSummary($model); ?>
	
	<div style="float: left; width: 50%;">

	<div class="row">
		<?php echo $form->labelEx($model,'pp_purordnum'); ?>
		<?php echo $form->textField($model,'pp_purordnum', array('readonly' => 'true')); ?>
		<?php echo $form->error($model,'pp_purordnum'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_date'); ?>
		<?php // echo $form->textField($model,'pp_date'); ?>
		<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
			$this->widget('CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'pp_date', //attribute name
				'language'=> '',
				'mode'=>'date', 
				'options'=>array(
					'dateFormat' => 'yy-mm-dd',
					'showAnim'=>'fold',
					'changeMonth' => 'true',
					'changeYear' => 'true',
					'showOtherMonths' => 'true',
					'selectOtherMonths' => 'true',
					'showOn' => 'both',
					'buttonImage'=>Yii::app()->baseUrl.'/images/date.png',
			),
			'htmlOptions'=>array(
				'value'=>CTimestamp::formatDate('Y-m-d'),
			)
		));?> 
		<?php echo $form->error($model,'pp_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cm_supplierid'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model, //Model object
				'name'=>'cm_supplierid',
				'attribute'=>'cm_supplierid', //attribute name
		        'sourceUrl' => Yii::app()->createUrl('purchaseordhd/Acomplete'),
		        'options'=>array(
		            'minLength'=>'1',
					'showAnim'=>'fold',
					'type' => 'get',
					'select'=>'js:function(event, ui) {
						$("#selectid").text(ui.item.value);
						$("#supplier_name").text(ui.item.label);
					}'
		        ),
		        'htmlOptions'=>array(
		            'class'=>'input-1',
		          	'id' =>'selectid',
		        	'placeholder'=>'search by name',
		        ),
		    )); ?>

		<?php echo $form->error($model,'cm_supplierid'); ?>
	</div>
	
	<div class="row" style="margin-bottom: 9px; font-size: 13px;">
		Supplier Name: <span id="supplier_name" style="margin-left: 50px; width: 100%; background: #eee;"> &nbsp; </span>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pp_requisitionno'); ?>
		<?php // echo $form->dropDownList($model,'pp_requisitionno',CHtml::listData(Purchaseordhd::model()->findAll(array('order'=>'pp_requisitionno DESC', 'limit'=>'5')), 'pp_requisitionno', 'pp_requisitionno')); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model, //Model object
				'name'=>'pp_requisitionno',
				'attribute'=>'pp_requisitionno', //attribute name
		        'sourceUrl' => Yii::app()->createUrl('purchaseordhd/getreqno'),
		        'options'=>array(
		            'minLength'=>'1',
					'showAnim'=>'fold',
					'type' => 'get',
					'select'=>'js:function(event, ui) {
						$("#reqno").text(ui.item.value);
						disableInput();
					}'
		        ),
		        'htmlOptions'=>array(
		            'class'=>'input-1',
		          	'id' =>'reqno',
		        	'placeholder'=>'search by typing R',
		        ),
		    )); ?>

		<?php echo $form->error($model,'pp_requisitionno'); ?>
	</div>

	<!-- Readonly requisition field after search by requisition -->
	<script type="text/javascript">
			function disableInput(){
				$("#reqno").prop('readonly', true);
			}
	</script>



	<div class="row">
		<?php echo $form->labelEx($model,'pp_payterms'); ?>
		<?php echo $form->dropDownList($model,'pp_payterms',array('Cash'=>'Cash','Credit'=>'Credit')); ?>
		<?php echo $form->error($model,'pp_payterms'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'pp_deliverydate'); ?>
		<?php // echo $form->textField($model,'pp_deliverydate'); ?>
		<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
			$this->widget('CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'pp_deliverydate', //attribute name
				'language'=> '',
				'mode'=>'date', 
				'options'=>array(
					'dateFormat' => 'yy-mm-dd',
					'showAnim'=>'fold',
					'changeMonth' => 'true',
					'changeYear' => 'true',
					'showOtherMonths' => 'true',
					'selectOtherMonths' => 'true',
					'showOn' => 'both',
					'buttonImage'=>Yii::app()->baseUrl.'/images/date.png',
			),
			'htmlOptions'=>array(
				'value'=>CTimestamp::formatDate('Y-m-d', strtotime("tomorrow")),
			)
		));?> 
		<?php echo $form->error($model,'pp_deliverydate'); ?>
	</div>


</div>
        
        
<div style="float: left; width: 50%;">



	<div class="row">
		<?php echo $form->labelEx($model,'pp_store'); ?>
		<?php // echo $form->dropDownlist($model,'pp_store', CHtml::listData(Branchmaster::model()->findAll(), 'cm_branch', 'cm_description')); ?>
		<?php $storeArray = CHtml::listData(Branchmaster::model()->findAll(),'cm_branch','cm_description');
           echo $form->dropDownList($model,'pp_store', $storeArray, 
                          array(
                          		'empty'=>"- Select Warehouse -",
                                'ajax' => array(
	                                'type'=>'POST',
	                                'url'=>CController::createUrl('purchaseordhd/GetCurrency' ),
	                          		//'success'=>'js:function(data){$("#currencyid").val(data);}', 
                          			'update' => '#currencyid',  
									'data'=>array('store'=>'js:this.value',),   
            						'success'=> 'function(data) {$("#currencyid").empty();
                           		 	$("#currencyid").val(data);
                           		 	} ', 
                          ),
                 			     
            )); ?>
		<?php echo $form->error($model,'pp_store'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'pp_currency'); ?>
		<?php echo $form->textField($model,'pp_currency', array('id'=>'currencyid', 'readonly'=> true)); ?>
		<?php echo $form->error($model,'pp_currency'); ?>
	</div>
	
	<div class="row">
		<?php //echo $form->labelEx($model,'pp_taxrate'); ?>
		<?php // echo $form->textField($model,'pp_taxrate',array('size'=>20,'maxlength'=>20)); ?>
		<?php // echo $form->error($model,'pp_taxrate'); ?>
	</div>


	<div class="row">
		<?php //echo $form->labelEx($model,'pp_taxamt'); ?>
		<?php //echo $form->textField($model,'pp_taxamt',array('size'=>20,'maxlength'=>20)); ?>
		<?php //echo $form->error($model,'pp_taxamt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_discrate'); ?>
		<?php echo $form->textField($model,'pp_discrate',array('class'=>'discrate', 'id'=>'discrate' )); ?>
		<?php echo $form->error($model,'pp_discrate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_discamt'); ?>
		<?php echo $form->textField($model,'pp_discamt',array('class'=>'discamt', 'id'=>'discamt', 'readonly'=>true )); ?>
		<?php echo $form->error($model,'pp_discamt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_amount'); ?>
		<?php echo $form->textField($model,'pp_amount', array('class'=>'amount', 'id'=>'amount', 'readonly' => true ) ); ?>
		<?php echo $form->error($model,'pp_amount'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'pp_status'); ?>
		<?php echo $form->textField($model,'pp_status', array('value'=>'Open', 'readonly' => 'true')); ?>
		<?php // echo $form->dropDownList($model,'pp_status', $this->getStatusOptions()); ?>
		<?php echo $form->error($model,'pp_status'); ?>
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