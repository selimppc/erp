<?php
/* @var $this JournalController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
    'General Ledger',
    'Journal Voucher'=>array('admin'),
);

$this->menu=array(
	//array('label'=>'List Vouhcerheader', 'url'=>array('index')),
	array('label'=>'New Voucher Header', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
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
    <div id="flag_desc_text"><b>Journal Voucher:</b> To create new voucher header information, click the Menu tab <b>“New Voucher Header”</b>. You can also add new voucher details on existing Voucher by clicking the <b> “Voucher Number” </b> link. This link will redirect you to Voucher Detail. <b>Action</b> buttons will allow you to update and delete. </div>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vouhcerheader-grid',
	'dataProvider'=>$model->searchJournalVoucher(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'am_vouchernumber',
        array(
            'class'=>'CLinkColumn',
            'header'=>'Voucher Number',
            'labelExpression'=>'$data->am_vouchernumber',
            //'urlExpression'=>'array("journaldt/create", "am_vouchernumber"=>$data->am_vouchernumber )',
            'urlExpression'=>'$data->am_status!=="Posted" ? array("journaldt/create","am_vouchernumber"=>$data->am_vouchernumber) :
                            array("journaldt/adminView","am_vouchernumber"=>$data->am_vouchernumber)',
        ),
		'am_date',
		'am_referance',
		'am_year',
		'am_period',
		'am_branch',
		'am_note',
		'am_status',
		array(
			'class'=>'CButtonColumn',
            'header'=>'Action',
            'template'=>'{update}{delete}',

            'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',

            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>'update',
                    'visible'=>'$data->am_status!=="Posted"',
                ),

                'delete' => array
                (
                    'label'=>'delete',
                    'visible'=>'$data->am_status!=="Posted"',
                ),
            ),
		),

        array(
            'class'=>'CButtonColumn',
            'header' => 'Reports',
            'template'=>'{toPDF}{toExcel}',
            'buttons'=>array
            (
                'toPDF' => array
                (
                    'label'=>'toPDF',
                    'url'=>'Yii::app()->createUrl("sareport/singleVoucher/", array("pVoucherNo"=>$data->am_vouchernumber) )',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/action_btn_pdf.png',
                    'options'=>array('target'=>'_blank'),
                ),
                'toExcel' => array
                (
                    'label'=>'toExcel',
                    'url'=>'Yii::app()->createUrl("sareport/singleVoucher/", array("pVoucherNo"=>$data->am_vouchernumber) )',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/action_btn_xls.png',
                    'options'=>array('target'=>'_blank'),
                ),
            ),
        ),
	),
)); ?>
