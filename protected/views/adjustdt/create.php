<?php
/* @var $this AdjustdtController */
/* @var $model Adjustdt */

$this->breadcrumbs=array(
    'Inventory',
	'Stock Adjustment'=>array('adjusthd/admin'),
	'New Stock Adjustment',
    'Detail',
);

$this->menu=array(
	array('label'=>'<< Back to Adjustment Header', 'url'=>array('adjusthd/admin')),
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
        <div id="flag_desc_text">Adjustment Detail</div>
    </div>


    <div style="width: 99%; float: left;">
        <div style="width: 47%; float: left; margin-right: 3%;">
            <?php $this->renderPartial('_form', array('model'=>$model, 'branch'=>$branch,)); ?>
        </div>

        <div style="width: 50%; float: left;">

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'adjustdt-grid',
                'dataProvider'=>$adjustDt->search($transaction_number),
                'filter'=>$adjustDt,
                'columns'=>array(
                    //'id',
                    //'transaction_number',
                    'product_code',
                    array( 'name'=>'product_search', 'value'=>'$data->product->cm_name' ),
                    'batch_number',
                    'expirry_date',
                    'unit',
                    'quantity',
                    'stock_rate',

                    array(
                        'class'=>'CButtonColumn',
                        'header'=>'Action',
                        'template'=>'{update}{delete}',

                        'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',


                        'buttons'=>array
                        (
                            'update' => array
                            (
                                'url'=>
                                'Yii::app()->createUrl("adjustdt/update/",
                                                        array("id"=>$data->id, "transaction_number"=>$data->transaction_number,
                                                        ))',
                            ),

                        ),
                    ),
                ),
            )); ?>

        </div>
    </div>

