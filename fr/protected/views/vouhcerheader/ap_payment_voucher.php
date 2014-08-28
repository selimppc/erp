<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Account Payable'=>array('vouhcerheader/appayment'),
	'New  Account Payable',
);

$this->menu=array(
	array('label'=>'Manage Account Payable', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('vouhcerheader/appayment')),
);
?>

<style type="text/css">
	table .money-receipt-sales, td, th
	{
		border: 1px solid #4E8EC2;
	}

#Vouhcerheader_am_currency{
	width: 140px;
}
</style>

<script type="text/javascript">

function getMe(){
	
	var vdate = document.getElementById("date_formate_v").value;
	var year = vdate.substring(0,4);

	
	
	var month = vdate.substring(5,7);
	var offset = document.getElementById("offset_pre").value;
	var period =  12 + parseInt(month) - parseInt(offset);
	//alert(month);
	//exit;
	
	if (parseInt(period) > 12 ){
		 postPeriod =  parseInt(period) - 12;
		 document.getElementById("period_new").value = postPeriod;
		}else{		
		document.getElementById("period_new").value = period;
	}
	if(parseInt(period) <= 12){
			yearA = parseInt(year) -1;
			document.getElementById("year_new").value = yearA;
		}else{
			document.getElementById("year_new").value = year;	
		}
	}



var id=0;
var addedProductCodes = [];

$(document).ready(function(){
	$(".items tr").click(function() {

	    var tableData = $(this).children("td").map(function() {
	        return $(this).text();
	    }).get();

	    var total = document.getElementById("sm_totalamt").value;
	    //total = parseInt(total) + parseInt($.trim(tableData[1]));

	    var value = parseInt($.trim(tableData[1]));			
	    var preBalance = document.getElementById("balance").value ;
	    
	    var td_productCode = $.trim(tableData[0]);
  
	   
	    
		var index = $.inArray(td_productCode, addedProductCodes);
		if (index >= 0) {
			alert("You already added this Product");
			exit;
		} else {
			    if (preBalance >= value ){
			    	$("#test").append(
				    		"<tr><td><input name='am_invnumber[]' value='"+ $.trim(tableData[0]) +"' style='width: 97%;' readonly ></td><td><input name='am_amount[]' value='"+ value +"' style='width: 97%; text-align: right;' readonly ></td>  <td><input value='"+ $.trim(tableData[2]) +"' readonly style='width: 97%; text-align: right;'></td> <td><input value='"+ $.trim(tableData[3]) +"' readonly style='width: 97%; text-align: right;' ></td> <td><input value='"+ $.trim(tableData[4]) +"' readonly style='width: 97%; text-align: right;'></td></tr>");
	
					var balance = parseInt(preBalance) - parseInt(value);
			    	document.getElementById("balance").value = balance;
			    	document.getElementById("sm_totalamt").value = parseInt(value) + parseInt(total);
	
				}else if (preBalance < value && preBalance != 0){
					$("#test").append(
				    		"<tr><td><input name='am_invnumber[]' value='"+ $.trim(tableData[0]) +"' style='width: 97%;' readonly ></td><td><input name='am_amount[]' value='"+ preBalance +"' style='width: 97%; text-align: right;' readonly ></td><td><input value='"+ $.trim(tableData[2]) +"' readonly style='width: 97%; text-align: right;' ></td> <td><input value='"+ $.trim(tableData[3]) +"' readonly style='width: 97%; text-align: right;'></td> <td><input value='"+ $.trim(tableData[4]) +"' readonly style='width: 97%; text-align: right;'></td></tr>");
					var balance = parseInt(preBalance) - parseInt(preBalance);
					document.getElementById("balance").value = balance;
					document.getElementById("sm_totalamt").value = parseInt(total) + parseInt(preBalance);
	
				}else{
					alert("Amount is not sufficient");
					exit;
				}

			    addedProductCodes.push(td_productCode);
		}

	});
});

function deleteRow(value, row)
{
	$(row).closest('tr').remove();

	var preTotal =document.getElementById("sm_totalamt").value;
	total = parseFloat(preTotal) - parseFloat(value);
	document.getElementById("sm_totalamt").value = parseFloat(total).toFixed(2);
}

function balanceAmount(){
	
	var amount = document.getElementById("cm_net_amount").value;

	var unpaidtotalamount = document.getElementById("unpaidtotalamount").innerHTML;

	if( parseInt(amount) > parseInt(unpaidtotalamount) ){
			alert(" Ops! Amount is Bigger than unpaid Amount");
			document.getElementById("balance").value = 0;
			document.getElementById("cm_net_amount").value = 0.00;
			exit;
		}else{

			
			document.getElementById("balance").value = amount;
			
		}
	
}



</script>




<h1>Accopunt Payable Voucher </h1>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vouhcerheader-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	//'focus'=>array($model,'am_vouchernumber'),
)); ?>

<input id="offset_pre" type="hidden" value="<?php echo $offset; ?>" />	





<div style="width: 55%; float: left;">

<table>
	<tr> 
		<td colspan="4" style="text-align: center; background: #4085BB; color: white;"> 
			Payment Voucher
		</td>
	</tr>
	
	<tr>
		<td> Payment Voucher #	</td>
		<td> <?php echo $form->textField($model, 'am_vouchernumber', array('style'=>'width: 140px;') ); ?> 
		</td>
		<td> Date </td>
		<td colspan="2"> 
			<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'am_date', //attribute name
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
					'id'=>'date_formate_v',
					'style' => 'width: 140px;',
					'onchange' => 'getMe()',
				),
			));?> 
		 </td>
	</tr>

	<tr> 
		<td> Year </td>
		<td> <?php echo $form->textField($model,'am_year', array('id'=>'year_new', 'style'=>'width: 140px;', 'readonly'=>'readonly')); ?> </td>
		<td> Period </td>
		<td> <?php echo $form->textField($model,'am_period',  array('id'=>'period_new', 'style'=>'width: 140px;', 'readonly'=>'readonly')); ?> </td>
	</tr>
	
	<tr>
		
		<td> Status </td>
		<td> <?php echo $form->textField($model,'am_status',  array('value'=>'Balanced', 'readonly'=>'readonly', 'style'=>'width: 140px;')); ?> </td>
		<td> Brach Code </td>
		<td colspan="2"> <?php // echo $form->textField($model,'am_branch',  array('style'=>'width: 140px;')); ?> 
				<?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'am_branch',
						'model'=>$model,
						'attribute'=>'am_branch',
						'source'=>CController::createUrl('/vouhcerheader/GetBranchNameAp'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#am_branch").val(ui.item.value);
								$("#newwewe").val(ui.item.exchangerate);
								getPackages(ui.item.value, ui.item.currency);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'am_branch',
							//'rel'=>'val',
							'placeholder'=>'search by branch name',
							'style'=>'width: 140px;',
							'required'=>'required',
						),
					));
				?> 
		</td>
	</tr>
	
<?php Yii::app()->clientScript->registerScript("selimreza","
        function getPackages(value, currency){

            $.ajax({
                url: '". $this->createUrl('vouhcerheader/dynamicpackage')."',
                data: 'value='+value + '&currency=' + currency,

                success: function(packages) {
                         $('#".CHtml::activeId($model, 'am_currency')."').html(packages);
                      }
            });
        }
	",CClientScript::POS_END);
?>


	<tr> 
		<td> Payment From A/C # </td>
		<td> <?php // echo $form->textField($model,'am_branch',  array('style'=>'width: 140px;')); ?> 
				<?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'am_creditorac',
						//'model'=>$model,
						//'attribute'=>'am_branch',
						'source'=>CController::createUrl('/vouhcerheader/getpaymentcode'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#payment_from_ac").val(ui.item.value);
								$("#account_description").text(ui.item.label);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'payment_from_ac',
							//'rel'=>'val',
							'placeholder'=>'search by account',
							'style'=>'width: 140px;',
							'required'=>'required',
						),
					));
				?> 
		</td>
		<td> Description </td>
		<td> <span id="account_description"></span></td>
	</tr>
	
	<tr>
		<td colspan="2"> Amount: </td>
		<td colspan="2"> 
			<input type="text" name="am_primeamt" style="width: 240px; text-align: right;" value="0.00" id="cm_net_amount" onchange="balanceAmount()" >
			<input type="hidden" id="balance" value="0" style="width: 50px;">
		</td>
	</tr>
	
	<tr>
		<td> Currency: </td>
		<td> 
			<?php echo $form->dropDownList($model,'am_currency', array(), 
					array(
                        'empty'=>'- Select Currency -',
                        'ajax'=>array(
                            'type'=>'POST',
                            'url' => CController::createUrl('Vouhcerheader/GetExchagerate'),
                            'update' => '#newwewe',  
							'data'=>array('store'=>'js:this.value',),   
            				'success'=> 'function(data) {$("#newwewe").empty();
                           		$("#newwewe").val(data);
                           	} ', 
                        )) 
			); ?>
			
		
		</td>
		<td> Excahnge Rate </td>
		<td> <input id="newwewe" name="am_exchagerate" style="width: 140px;" readonly/>	</td>
	</tr>
	
	<tr>
		<td> Debtor A/C #</td>
		<td style="background: white;"> <?php echo $accoutcode; ?></td>
		<td> Description </td>
		<td> <?php echo $debator; ?></td>
	</tr>
	
	<tr>
		<td> Supplier Code </td>
		<td> <?php echo $suppliercode; ?></td>
		<td> Name </td>
		<td> <?php echo $suppliername; ?></td>
	</tr>


	
	<tr> 
		<td> Note </td>
		<td colspan="5"> <?php echo $form->textArea($model,'am_note',array('style'=>'font-size: 12px; color: #666; width: 99%;')); ?> </td>
	</tr>
</table>


</div>


<div style="width: 40%; float: left;">


<table style="width: 95%; margin-bottom: 30px;">
		<tr>
			<td colspan="4" style="text-align: center; background: #4085BB; color: white; font-weight: bold;"> 
				Unpaid Invoice List of - <?php echo $suppliername; ?> 
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<thead>
						<tr>
							<th width="270">Invoice No</th>
							<th width="270">Amount Payable</th>
							<th width="200"> Currency </th>
							<th width="200">Exchange Rate</th>
							<th width="200">Prime Amount</th>
						</tr>
					</thead>

					<tbody class="items">
						<?php   foreach($unpayinvoice as $values): { ?>
							<tr style="background: white;">
								<td><?php  echo $values['invoicnumber']; ?></td>
								<td style="text-align: right;"><?php  echo $values['amount']; ?></td>
								<td><?php  echo $values['currency']; ?></td>
								<td><?php  echo $values['exchange']; ?></td>
								<td><?php  echo $values['primaamt']; ?></td>
								
							</tr>
						<?php  } endforeach; ?>

					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;"> Total: <span id="unpaidtotalamount"><?php  echo $unpamt; ?></span> </td>
		</tr>
	</table>


<table style="width: 95%; margin-bottom: 30px;">	
		<tr>
			<td colspan="4" style="text-align: center; background: #4085BB; color: white; font-weight: bold;"> Allocated Invoice</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<table>
					<thead>
						<tr>
							<th width="100"> Invoice No </th>
							<th width="100"> Amount </th>
							<th> Currency </th>
							<th> Exchange Rate </th>
							<th> Prime Amount </th>
						</tr>
					</thead>

					<tbody id="test">
						<tr>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
							<td> </td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</table>


	<table style="width: 95%; float: left;">
		<tr>
			<td>
				<table>
					<tr> 
						<td style="width:  30%;"> Total </td>
						<td style="width: 70%; ">
							<input type="text"  id="sm_totalamt" value="0" readonly style="text-align: right;">
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>

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
		<?php echo $form->hiddenField($model,'insertuser'); ?>
		<?php //echo $form->error($model,'insertuser'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updateuser'); ?>
		<?php echo $form->hiddenField($model,'updateuser'); ?>
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

