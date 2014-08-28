<!--Generated using Gimme CRUD freeware from www.HandsOnCoding.net -->
<?php
$this->breadcrumbs=array(
	'Customer Master'=>array('customermst/admin'),
	'Settings -> Update Customer Transaction No',
);


$this->menu=array(
	array('label'=>'Manage Customer Transaction No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/manageCustmerTrnNo')),
); 
?>


<div id="statusMsg">
    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
            <?php

            Yii::app()->clientScript->registerScript(
                'myHideEffect',
                '$(".flash-success").animate({opacity: 1.0}, 9000).fadeOut("slow");',
                CClientScript::POS_READY
            );
            ?>
        </div>
    <?php endif; ?>

    <?php if(Yii::app()->user->hasFlash('error')):?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
            <?php

            Yii::app()->clientScript->registerScript(
                'myHideEffect',
                '$(".flash-error").animate({opacity: 1.0}, 9000).fadeOut("slow");',
                CClientScript::POS_READY
            );
            ?>
        </div>
    <?php endif; ?>

</div>


<div id="flag_desc">
    <div id="flag_desc_img"><img src="<?php echo Yii::app()->baseUrl.'/images/why.png'; ?>" /></div>
    <div id="flag_desc_text"> Update Customer Settings </div>
</div>


<?php echo $this->renderPartial('_from_customer_no', array('model'=>$model)); ?>
