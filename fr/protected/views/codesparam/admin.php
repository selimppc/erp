<?php
$this->breadcrumbs=array(
	'Codes Param'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Codesparams', 'url'=>array('index')),
	array('label'=>'New Codes Param', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),

);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('codesparamgrid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Codes Params</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'codesparamgrid',
    'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'columns'=>array(
        'cm_type',
        'cm_code',
        'cm_desc',
        'cm_active',
        'inserttime',
        'updatetime',
        'insertuser',
        'updateuser',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array
            (
                'view' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("codesparam/view/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                ),
                'update' => array
                (
                    'url'=>
                    'Yii::app()->createUrl("codesparam/update/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                ),
                'delete'=> array
                (	
                    'url'=>
                    'Yii::app()->createUrl("codesparam/delete/", 
                                            array("cm_type"=>$data->cm_type, "cm_code"=>$data->cm_code
											))',
                'visible'=> '$data->cm_active=="0"',
                ),
            ),
        ),
    ),
)); ?>
