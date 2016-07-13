<?php
/* @var $this DesireController */
/* @var $model Desire */

$this->breadcrumbs=array(
	'Desires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Desire', 'url'=>array('index')),
	array('label'=>'Manage Desire', 'url'=>array('admin')),
);
?>

<h1>Create Desire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>