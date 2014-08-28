<?php
/* @var $this SmheaderController */
/* @var $model Smheader */
/* @var $form CActiveForm */
?>
<style type="text/css" >
tbody #test tr td .close-button{
	background: none repeat scroll 0 0 #FF9900;
    border: medium none;
    border-radius: 5px;
    color: #FFFFFF;
    cursor: pointer;
    padding: 0px 5px;
}

table .money-receipt-sales, td, th
{
	border: 1px solid #4E8EC2;
}
#button_add{
	text-align: center;
	background: orange;
	color: white;
	cursor: pointer;
	padding: 3px 8px;
	border-radius: 3px;
	font-weight: bold;
}
#Vouhcerheader_voucher_no{
	width: 140px;
}
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sm-header-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'cm_cuscode'),
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php // echo $form->errorSummary($model); ?>


<script type="text/javascript">
	var id=0;
	$(document).ready(function(){
		$("#button_add").click(function() {
		    var tableData = $(this).closest("tr").find("td input").map(function() {
		        return $(this).val();
		    }).get();

		    var product_name = $.trim(tableData[0]);
			var code = $.trim(tableData[1]);
			var sellRate = Math.round(($.trim(tableData[2]))*100)/100;
			var taxRate = Math.round(($.trim(tableData[3]))*100)/100;
			var quantity = Math.round(($.trim(tableData[4]))*100)/100;
			var unit = $.trim(tableData[5]);
			var total = Math.round(($.trim(tableData[6]))*100)/100;
			var available = $.trim(tableData[8]);

			var sm_totalamt = Math.round((document.getElementById("sm_totalamt").value)*100)/100;
			var sm_total_tax_amt = Math.round((document.getElementById("sm_total_tax_amt").value)*100)/100;
			var total_tax_amt = Math.round(((taxRate * total)/100)*100)/100;
			//var sm_disc_rate = document.getElementById("sm_disc_rate").value;
			//var sm_disc_amt = document.getElementById("sm_disc_amt").value;
			var sm_netamt = Math.round((document.getElementById("sm_netamt").value)*100)/100;
			id=id+1;

			if(quantity == ""){	
					alert("Please Add Quantity !!!");
					exit;

				}else{
					$("#test").append(
							"<tr><td><input type='' value='"+ product_name +"'  readonly></td><td><input type='' name='cm_code[]' value='"+ code +"' style='width: 100px' readonly></td><td><input type='' id='sellRate_"+id+"' name='sm_rate[]' value='"+ sellRate +"' style='width: 100px' readonly></td><td><input type='' name='sm_tax_rate[]' id='taxRate_"+id+"' value='"+ taxRate +"' style='width: 100px' readonly></td><td><input name='sm_quantity[]' value='"+ quantity +"'  style='width: 100px' readonly></td><td><input type='' name='sm_unit[]' value='"+ unit +"' style='width: 100px' readonly></td><td><input type='' name='sm_lineamt[]' id='price_"+id+"' price='"+ sellRate +"' value='"+ sellRate +"' style='width: 100px' readonly ></td><td><span onclick='deleteRow(\"" + sellRate + "\", \"" + taxRate + "\", \"" + quantity + "\", this)' style='background:orange; color:white; border-radius: 3px; cursor: pointer; padding: 1px 3px; margin-left: 5px;' id='delete_button'> x </span></td></tr>"
							);	

					document.getElementById("sm_totalamt").value = Math.round((sm_totalamt + total)*100)/100;
					document.getElementById("sm_total_tax_amt").value = Math.round((sm_total_tax_amt + total_tax_amt)*100)/100;
					document.getElementById("sm_netamt").value = Math.round((sm_netamt + total + total_tax_amt)*100)/100;
			}
		});
	});

	function primeMultiply(){
		var quantity_a = document.getElementById("quantity_a").value;
		var total_a = document.getElementById("total_a").value;

		var available = document.getElementById("available").value;

		if(parseInt(quantity_a) > parseInt(available)){
				alert("Product Quantity is not Available !!!");
				document.getElementById("quantity_a").value = " ";
				exit;
			}else{
				var total = Math.round((quantity_a * total_a)*100)/100;		
				document.getElementById("total").value = total;
			}
		
	}


	function discoutnRate(){
		var total = Math.round((document.getElementById("sm_netamt").value)*100)/100;
		var disc = Math.round((document.getElementById("sm_disc_rate").value)*100)/100;
		var discountamount = Math.round((total * disc / 100)*100)/100; 
		
		document.getElementById("sm_disc_amt").value = discountamount;
		
		var totalamt = Math.round((document.getElementById("sm_netamt").value)*100)/100;
		var netamt = Math.round((totalamt - discountamount)*100)/100;
		document.getElementById("sm_netamt").value = netamt;
		
	}
	function discoutnAmount(){
		var discamt11 = Math.round((document.getElementById("sm_disc_amt").value)*100)/100;
		var totalamt = Math.round((document.getElementById("sm_netamt").value)*100)/100;
		var netamt11 = Math.round(( totalamt - discamt11)*100)/100;

		document.getElementById("sm_netamt").value = netamt11;
	}

	$(document).ready(function(){
		$('#sm_disc_rate').change(function(){
			var dueamt = document.getElementById("sm_disc_rate").value;
			if(dueamt > 0 ){
				$("#sm_disc_amt").prop('readonly', true);
			}else{
				$("#sm_disc_rate").prop('readonly', true);
			}
			});
	});

	function deleteRow(sellRate, taxRate, quantity, row)
	{
		$(row).closest('tr').remove();
		
		var total= Math.round((document.getElementById("sm_totalamt").value)*100)/100;
		var Rate = Math.round((sellRate * quantity)*100)/100;
		total = Math.round((total - Rate)*100)/100;

		var tax1 = Math.round((document.getElementById("sm_total_tax_amt").value)*100)/100;
		taxamount = Math.round((tax1 - (sellRate * taxRate * quantity / 100))*100)/100;

		var sm_netamt = Math.round((document.getElementById("sm_netamt").value)*100)/100;
		sm_netamt = Math.round((sm_netamt - (Rate + (sellRate * taxRate * quantity / 100) ))*100)/100;
		
		document.getElementById("sm_totalamt").value = Math.round((total)*100)/100;
		document.getElementById("sm_total_tax_amt").value = taxamount;
		document.getElementById("sm_netamt").value = sm_netamt;
	}
	
</script>

<div> 
	<table>
		<tr> 
			<td colspan="4" style="text-align: center; background: #4085BB; color: white;"> 
				Sales Invoice
			</td>
		</tr>
		
		<tr>
			<td> <?php echo $form->labelEx($model,'sm_number'); ?> </td>
			<td> <?php echo $form->textField($model,'sm_number',array('id'=>'sm_number', 'readonly'=>'readonly')); ?> </td>
			<td> <?php echo $form->labelEx($model,'sm_date'); ?> </td>
			<td> <?php echo $form->textField($model,'sm_date', array('id'=>'sm_date', 'readonly'=>'readonly')); ?> </td>
		</tr>
		
		<tr>
			<td> <?php echo $form->labelEx($model,'cm_cuscode'); ?> </td>
			<td> 
				 <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'cm_cuscode',
						'model'=>$model,
						'attribute'=>'cm_cuscode',
						'source'=>CController::createUrl('/smheader/customercode'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event,ui) {
									$("#cm_cuscode12").val(ui.item.value);
									$("#customer_name").text(ui.item.label);
									$("#sp_name").val(ui.item.sp);
		                         }'
						),
						'htmlOptions'=>array(
							'id'=>'cm_cuscode12',
							'placeholder'=>'search by customer name',
						),
					)); ?>
			</td>
			<td> Customer Name </td>
			<td> <span id="customer_name"></span> </td>
		</tr>
		
		<tr>
			<td> <?php echo $form->labelEx($model,'sm_sp'); ?> </td>
			<td> <?php echo $form->textField($model,'sm_sp',array('id'=>'sp_name','readonly'=>'readonly')); ?> </td>
			<td> Sales Person Name </td>
			<td> </td>
		</tr>
		
		<tr>
			<td> <?php echo $form->labelEx($model,'sm_payterms'); ?> </td>
			<td> <?php echo $form->dropDownList($model,'sm_payterms', array('Cash'=>'Cash','Credit'=>'Credit'), array('id'=>'sm_payterms')); ?> </td>
			<td> <?php echo $form->labelEx($model,'sm_storeid'); ?> </td>
			<td> <?php echo $form->dropDownList($model,'sm_storeid', CHtml::listData(Branchmaster::model()->findAll(array('order'=>'cm_branch ASC')), 'cm_branch', 'cm_description'), array('id'=>'sm_storeid')); ?> </td>
		</tr>
	
	</table>	
</div>
			<div class="row">
				<?php //echo $form->labelEx($model,'sm_doc_type'); ?>
				<?php echo $form->hiddenField($model,'sm_doc_type',array('value'=>'Sales', 'id'=>'sm_doc_type')); ?>
				<?php //echo $form->error($model,'sm_doc_type'); ?>
			</div>

<br>

<div>
	<table>
		<tr> 
			<td style="text-align: center; background: #4085BB; color: white;"> 
				Item Details
			</td>
		</tr>
	</table>
</div>

<div>	
	<table>	
		<thead>
			<tr>
				<th> Product Name </th>
				<th> Code </th>
				<th> Sell Rate </th>
				<th> Tax Rate </th>
				<th> Quantity </th>
				<th> Unit </th>
				<th> Total </th>
				<th> Action </th>
			</tr>
		</thead>
		
		<tbody>
			<tr> 
				<td> 
					<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'name'=>'product_name',
							'model'=>$model,
							'source'=>CController::createUrl('/smheader/autocompleteTestNew'),
							'options'=>array(
								'minLength'=>'1', 
								'select'=>'js:function( event, ui ) {
										$("#product_name").text(ui.item.label);
										$("#code").val(ui.item.code);
										$("#sell_rate").val(ui.item.rate);
										$("#tax_rate").val(ui.item.tax);
										$("#unit_a").val(ui.item.unit);
										$("#total_a").val(ui.item.rate);
										$("#available").val(ui.item.available);

										//$("#cm_code").val("");
			                            //  getProductData(ui.item.label,ui.item.code,ui.item.rate,ui.item.unit,ui.item.available,ui.item.tax);
			                             // return false;
			                         }',
							),
							'htmlOptions'=>array(
								'id'=>'product_name',
								'placeholder'=>'search by product name or code',
								//'style' => 'width: 96%; padding: 8px; margin-bottom: 10px; border: 1px solid orange;',
								//'onClick' => 'document.getElementById("cm_code").value= ""',
							),
						));?>
				</td>
				
				<td> <input id="code" style="width: 100px; padding: 3px;" readonly="readonly"/> </td>
				<td> <input id="sell_rate" style="width: 100px; padding: 3px;" readonly="readonly"/> </td>
				<td> <input id="tax_rate" style="width: 100px; padding: 3px;" readonly="readonly"/> </td>
				<td> <input id="quantity_a" style="width: 100px; padding: 3px; text-align: center;" onchange="primeMultiply()" placeholder="0" /> </td>
				<td> <input id="unit_a" style="width: 100px; padding: 3px;" readonly="readonly"/> </td>
				<td> <input id="total" value="0.00" style="width: 100px; padding: 3px; text-align: right;" readonly="readonly"/> 
					 <input type="hidden" id="total_a" style="width: 100px; padding: 3px;" readonly="readonly"/> 
					 <input type="hidden" id="available" style="width: 100px; padding: 3px;" readonly="readonly"/> 
					
				</td>
				<td> <span id="button_add"> Add </span> </td>
			</tr>
		</tbody>
	</table>		
</div>
<br>

<div>
	<table>
		<tbody id="test">
		</tbody>
	</table>
</div>

<div>
	<table style="margin-left: 58%; margin-top: 20px;"  CELLSPACING ="0">
		<tr> 
			 <td> <?php echo $form->labelEx($model,'sm_totalamt'); ?> </td>
			 <td> <?php echo $form->textField($model,'sm_totalamt',array('value'=>'0', 'id'=>'sm_totalamt','class'=>'sm_totalamt', 'readonly'=>'readonly', 'style'=>'width: 148px;')); ?> </td>
		</tr>	 
		<tr> 
			 <td> <?php echo $form->labelEx($model,'sm_total_tax_amt'); ?> </td>
			 <td> <?php echo $form->textField($model,'sm_total_tax_amt',array('value'=>'0', 'id'=>'sm_total_tax_amt','class'=>'sm_total_tax_amt', 'readonly'=>'readonly')); ?> </td>
		</tr>
		<tr> 
			 <td> <?php echo $form->labelEx($model,'sm_disc_rate'); ?> </td>
			 <td> <?php echo $form->textField($model,'sm_disc_rate',array('id'=>'sm_disc_rate','class'=>'sm_disc_rate', 'onchange' => 'discoutnRate();', 'placeholder'=>'0')); ?> </td>
		</tr>
		<tr> 
			 <td> <?php echo $form->labelEx($model,'sm_disc_amt'); ?> </td>
			 <td> <?php echo $form->textField($model,'sm_disc_amt',array('id'=>'sm_disc_amt','class'=>'sm_disc_amt', 'onchange' => 'discoutnAmount();', 'placeholder'=>'0')); ?> </td>
		</tr>
		<tr> 
			 <td> <?php echo $form->labelEx($model,'sm_netamt'); ?> </td>
			 <td> <?php echo $form->textField($model,'sm_netamt',array('value'=>'0', 'id'=>'sm_netamt','class'=>'sm_netamt', 'readonly'=>'readonly')); ?> </td>
		</tr>

	</table>
</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'sm_refe_code'); ?>
		<?php echo $form->hiddenField($model,'sm_refe_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php //echo $form->error($model,'sm_refe_code'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'sm_sign'); ?>
		<?php echo $form->hiddenField($model,'sm_sign', array('value'=>'1', 'readonly'=>'readonly')); ?>
		<?php //echo $form->error($model,'sm_sign'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'sm_stataus'); ?>
		<?php echo $form->hiddenField($model,'sm_stataus',array('value'=>'Open','readonly'=>'readonly')); ?>
		<?php //echo $form->error($model,'sm_stataus'); ?>
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
		<?php echo $form->hiddenField($model,'insertuser',array('size'=>20,'maxlength'=>20)); ?>
		<?php //echo $form->error($model,'insertuser'); ?>
	</div>

	<div class="row">
		<?php // echo $form->labelEx($model,'updateuser'); ?>
		<?php echo $form->hiddenField($model,'updateuser',array('size'=>20,'maxlength'=>20)); ?>
		<?php // echo $form->error($model,'updateuser'); ?>
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