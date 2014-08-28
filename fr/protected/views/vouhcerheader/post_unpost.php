<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Post & Unpost'=>array('admin'),
	'New Post & Unpost',
);

$this->menu=array(
	array('label'=>'Manage Post & Unpost', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>


<style type="text/css">
table .money-receipt-sales, td, th
{
	border: 1px solid #4E8EC2;
	line-height: 23px;
}

.radio_button{
	background: #4085BB;
	border-radius: 30px;
	
}
</style>


<h1>New Post - Unpost </h1>

<?php echo CHtml::beginForm($this->createUrl('/billing/default/create'), 'POST')?>



<table>
	<tr> 
		<td colspan="5" style="text-align: center; background: #4085BB; color: white;"> 
			Post Unpost
		</td>
	</tr>
	<tr> 
		<td> FROM </td> 
		<td> 
			<?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'am_branch',
						'model'=>$model,
						'attribute'=>'am_branch',
						'source'=>CController::createUrl('/vouhcerheader/GetVoucherNumber'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#from_voucher").val(ui.item.value);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'from_voucher',
							//'rel'=>'val',
							'placeholder'=>'search by voucher no',
							'style' => 'width: 140px;',
						),
					));
				?> 
		 </td>
		<td> TO </td> 
		<td> 
			<?php 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name'=>'am_branch',
						'model'=>$model,
						'attribute'=>'am_branch',
						'source'=>CController::createUrl('/vouhcerheader/GetVoucherNumber'),
						'options'=>array(
							'minLength'=>'1', 
							'select'=>'js:function(event, ui){
								$("#to_voucher").val(ui.item.value);
							}'
						),
						'htmlOptions'=>array(
							'id'=>'to_voucher',
							//'rel'=>'val',
							'placeholder'=>'search by voucher no',
							'style' => 'width: 140px;',
						),
					));
				?> 
		</td>
		<td class="radio_button"> <input type="radio" name="radio" style="width: 25px;"> </td> 
	</tr>
	
	<tr> 
		<td> Start Date </td> 
		<td> 
			<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'start_date', //attribute name
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
					'style' => 'width: 140px;'
				),
			));?> 
		</td>
		<td> End Date </td> 
		<td> 
			<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
				$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'end_date', //attribute name
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
					'style' => 'width: 140px;'
				),
			));?> 
		</td>
		<td class="radio_button"> <input type="radio" name="radio" style="width: 25px;"> </td> 
	</tr>
	
	<tr> 
		<td> Year </td> 
		<td> <input name="" value="" style="width: 140px;" > </td>
		<td> Period </td> 
		<td> <input name="" value="" style="width: 140px;"></td>
		<td class="radio_button"> <input type="radio" name="radio" style="width: 25px;" > </td> 
	</tr>
</table>


<div style="width: 600px; float: left; margin: 20px;">

	<div style="width: 40%; float: left; margin-right: 10%;">
		<?php echo CHtml::submitButton('Post', array('name' => 'post', 'style'=>'background:#4085BB; height: 40px; width:150px; color: white; cursor: pointer; font-weight: bold; border-radius: 3px;')); ?>
	</div>
	
	<div style="width: 45%; float: left;">
		<?php echo CHtml::submitButton('Unpost', array('name' => 'unpost', 'style'=>'background:#4085BB; height:40px; width:150px; color: white; cursor: pointer; font-weight: bold; border-radius: 3px;')); ?>
	</div>
	
</div>


<?php echo CHtml::endForm(); ?>

