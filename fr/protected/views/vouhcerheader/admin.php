<?php
/* @var $this VouhcerheaderController */
/* @var $model Vouhcerheader */

$this->breadcrumbs=array(
	'Voucher Header'=>array('admin'),
	'Manage Voucher',
);

$this->menu=array(
	//array('label'=>'List Voucher Header', 'url'=>array('index')),
	array('label'=>'New Voucher', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/create_a.png" /></span>{menu}', 'url'=>array('create')),
	array('label'=>'Settings', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/settings_a.png" /></span>{menu}', 'url'=>array(''), 'itemOptions'=>array('class'=>'productsubmenu'),
		'items'=>array(
				array('label'=>'Voucher No', 'template'=>'<span><img src="'.Yii::app()->baseUrl.'/images/manage_a.png" /></span>{menu}', 'url'=>array('transaction/managevoucherno')),
	),
	),
);


?>

<h1>Manage Voucher Header</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vouhcerheader-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		//'am_vouchernumber',
			array(
					'class'=>'CLinkColumn',
                    'header'=>'Voucher Number',
                    'labelExpression'=>'$data->am_vouchernumber',
                    'urlExpression'=>'array("vouhcerheader/viewGlTrn","am_vouchernumber"=>$data->am_vouchernumber,
                    "am_date"=>$data->am_date, "am_year"=>$data->am_year, "am_period"=>$data->am_period,
                    )',
                ),
		'am_date',
		'am_referance',
		'am_year',
		'am_period',
		'am_branch',
		'am_note',
		'am_status',
		//'inserttime',
		//'updatetime',
		//'insertuser',
		//'updateuser',
		array(
			'class'=>'CButtonColumn',
			'header' => 'Action',
			'template'=> '{view}',
		),
	),
)); ?>
