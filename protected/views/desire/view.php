<?php
/* @var $this DesireController */
/* @var $model Desire */

$this->breadcrumbs=array(
	'Desires'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Desire', 'url'=>array('index')),
	array('label'=>'Create Desire', 'url'=>array('create')),
	array('label'=>'Update Desire', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Desire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Desire', 'url'=>array('admin')),
);
?>

<h1>View Desire #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'title',
		'text',
		'single',
		'reserved',
	),
)); ?>
