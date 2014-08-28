<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Year End Process'=>array('admin'),
	'New  Year End Process',
);

$this->menu=array(
	array('label'=>'Manage Year End Process', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('admin')),
);
?>

<style type="text/css">
	table .money-receipt-sales, td, th
	{
		border: 1px solid #4E8EC2;
	}

</style>

<h1>Year End Process</h1>

<?php echo CHtml::beginForm($this->createUrl('/billing/default/create'), 'POST')?>

<table>
	<tr> 
		<td colspan="2" style="text-align: center; background: #4085BB; color: white;"> 
			Year End Process
		</td>
	</tr>
	
	<tr>
		<td> Year :  </td>
		<td> <input name="" value=""> </td>
	</tr>
	
	<tr>
		
		<td colspan="2"> 
			
			<?php echo CHtml::submitButton('Proceed to Year', array('style'=>'height: 30px;  border-radius: 5px; cursor: pointer;')); ?>
		</td>
	</tr>

</table>

	
<?php echo CHtml::endForm(); ?>