<?php
/* @var $this DesireController */
/* @var $model Desire */

$this->breadcrumbs=array(
	'Desires'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Desire', 'url'=>array('index')),
	array('label'=>'Create Desire', 'url'=>array('create')),
	array('label'=>'View Desire', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Desire', 'url'=>array('admin')),
);
?>

<h1>Update Desire <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>