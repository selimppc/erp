<?php
/* @var $this SmheaderController */
/* @var $model Smheader */

$this->breadcrumbs=array(
	'Invoice'=>array('smheader/admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'New Invoice', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('smheader/create')),
	array('label'=>'Manage Invoice', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('smheader/admin')),
	array('label'=>'Post to GL', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/post_gl_a.png" /></span>{menu}', 'url'=>array('smheader/postToGl')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Invoice No', 'url'=>array('transaction/manageinvoiceno')),
	),
	),
);

?>

<h1>Manage Invoice</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sm-header-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'sm_number',
		'sm_date',
		'cm_cuscode',
		'sm_sp',
		'sm_storeid',
		//'sm_doc_type',
		//'sm_territory',
		//'sm_rsm',
		//'sm_area',
		'sm_payterms',
		'sm_totalamt',
		'sm_total_tax_amt',
		//'sm_disc_rate',
		'sm_disc_amt',
		'sm_netamt',
		//'sm_sign',
		'sm_stataus',
		//'sm_refe_code',

		array(
            'class'=>'CButtonColumn',
			'header'=>'Action',
            'template'=>'{update}{delete}{confirm}',
            'buttons'=>array
            (
            	
            	'update'=> array
                (
                    'label'=>'update',     // text label of the button
                    //'url'=>'Yii::app()->createUrl("smheader/ApproveStatus/", array("id"=>$data->id))', 
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open" OR $data->sm_stataus=="Delivered"',
                ),
                'delete'=> array
                (
                    'label'=>'delete',     // text label of the button
                    //'url'=>'Yii::app()->createUrl("smheader/ApproveStatus/", array("id"=>$data->id))', 
                    //'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open" OR $data->sm_stataus=="Delivered"',
                ),
                'confirm'=> array
                (
                    'label'=>'confirm',     // text label of the button
                    'url'=>'Yii::app()->createUrl("smheader/ApproveStatus/", array("id"=>$data->id))', 
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/approved.png', 
        			'visible' => '$data->sm_stataus=="Open"',
                ),
            ),
        ),
	),
)); ?>
