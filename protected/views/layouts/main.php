<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/crop/css/jquery.Jcrop.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.css"/> -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap_yeti.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css">



<div class="frame">

	<?php 
		switch ($_GET['page']) {
	    case 'index':
	        $index='active';
	        break;
	    case 'friends':
	        $friends='active';
	        break;
	    // case 'wellcome':
	    //     $wellcome='active';
	    //     break;
	    default: 
	    	$index='active';   
	    	$friends='';   
	    	$wellcome='';   
		}
	?>




		<div class="navbar navbar-fixed-top">
			<ul class="nav nav-tabs">
			  	<li role="presentation" class="<?php echo $index; ?>"><?php echo CHtml::link('Ваши желания', array('desire/index', 'page'=>'index', 'viewer_id'=>$_GET['viewer_id'])); ?></li>
				
				<?php if (Desire::get_publish_desires_count(Yii::app()->user->id) == 0): ?>

				<li role="presentation" class="<?php echo $friends; ?>"><?php echo CHtml::link('Желания друзей', '' , array('onclick'=>'NoDesires()')); ?></li>
				<?php else: ?>
				<li role="presentation" class="<?php echo $friends; ?>"><?php echo CHtml::link('Желания друзей', array('desire/friends', 'page'=>'friends', 'viewer_id'=>$_GET['viewer_id'])); ?></li>
				<?php endif; ?>



			  <!-- <li role="presentation" class="<?php echo $wellcome; ?>"><?php echo CHtml::link('Рассказать друзьям', array('desire/wellcome', 'page'=>'wellcome', 'viewer_id'=>$_GET['viewer_id'])); ?></li> -->
			</ul>
		</div>

		<div class="frame-content">

			<?php echo $content; ?>

		</div>
</div>




<?php Yii::app()->getClientScript()->registerCoreScript('jquery');  ?> 	

<script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/crop/js/jquery.Jcrop.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/crop/js/script.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/dotdotdot/jquery.dotdotdot.min.js"></script>




