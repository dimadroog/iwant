	<h3>Ваши желания</h3>
	<h4>Опишите, что бы Вы хотели в подарок от своих близких</h4>
	<p><a onclick="invite()">Пригласить друзей</a></p>

<?php //var_dump($_GET['viewer_id']); ?>

<div class="no-desires">
	<p id="no_desires" style="display:none" class="text-danger">Для того чтобы посмотреть желания Ваших друзей, необходимо добавить свое желание.</p>
</div>

<?php $this->renderPartial('desireform'); ?>

<br>

<?php foreach ($desires as $key => $desire): ?>

	<div class="recovery-block" id="recovery_block<?php echo $key;?>" style="display:none">
		Запись удалена. <a onclick="DesireRecovery(<?php echo $key;?>,<?php echo $desire->id;?>)">Восстановить.</a>
	</div>

	<?php 
	if ($desire->giver_id == 0){
			$block_color = "bg-default";
		} else {
			$block_color = "bg-primary";
		}
	?>

	<div class="row gift-block <?php echo $block_color; ?>" id="gift_block<?php echo $key;?>" onmouseenter="ShowManageLink(<?php echo $key;?>)">

		<a id="manage_link<?php echo $key;?>"
		    class="manage-link" 
		    data-toggle="tooltip" 
		    data-placement="left" 
		    title="Удалить запись" 
		    style="display:none"
		    onclick="DesireUnpublish(<?php echo $key;?>,<?php echo $desire->id;?>)">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</a>


		<div class="col-xs-3">
			<?php 
			if ($desire->img) {
				echo '<img class="gift" src="'.Yii::app()->request->baseUrl.'/'.$desire->img.'">';
			} else {
				echo '<img src="'.Yii::app()->request->baseUrl.'/images/gift200.jpg" class="default-gift">';
			}
			?>
		</div>

		<div class="col-xs-9">
			<span class="desire-title" onclick="ShowAllText(<?php echo $key;?>)">
				<?php echo $desire->title; ?>
			</span>

			<?php if ($desire->text): ?>

				<article>

					<div class="text_review" id="text<?php echo $key;?>" onclick="ShowAllText(<?php echo $key;?>)">
						 <?php echo nl2br(strip_tags($desire->text)); ?>
					</div>

				</article>

				<div class="text_full" id="full_text<?php echo $key;?>" onclick="ShowAllText(<?php echo $key;?>)" style="display:none">
					 <?php echo nl2br(strip_tags($desire->text)); ?>
				</div>
			<?php else: ?>

				<div style="height: 49px;"></div>

			<?php endif; ?>	
			<?php if ($desire->giver_id != 0): ?>	
				<div class="text-right who-giver-abs" style="margin-top: 7px;">
					<?php if ($desire->paid == 0): ?>
					<div id="who_giver<?php echo $desire->id; ?>">	
						<b>Вам пообещали подарить! <a class="" onclick="order(<?php echo $desire->id; ?>)">Узнать кто</a></b>
					</div>	
					<div id="hidden_giver<?php echo $desire->id; ?>" style="display:none">	
						<b><?php echo User::get_user_vk_link($desire->id); ?> обещал подарить Вам это.</b> 
					</div>	
					<?php else: ?>	
						<b><?php echo User::get_user_vk_link($desire->id); ?> обещал подарить Вам это.</b>
					<?php endif; ?>	
				</div> 		
			<?php endif; ?>	

		</div>


	</div>
<?php endforeach; ?>
<script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script>

 <script type="text/javascript">
	function invite() {
	    VK.callMethod('showInviteBox');
	}
 

	  function order(desire) {
	    var params = {
	      type: 'item',
	      item: 'desire',
	      item_id: desire
	    };
	    VK.callMethod('showOrderBox', params);

		  var callbacksResults = document.getElementById('callbacks');

		  VK.addCallback('onOrderSuccess', function(order_id) {
		    // callbacksResults.innerHTML += '<br />onOrderSuccess '+order_id+' '+desire;
	    	jQuery.ajax({
				type: 'POST',
				url: '<?php echo Yii::app()->createUrl('desire/paid/'); ?>',
				data: {desire},
				success: function(data){
					jQuery('#who_giver'+desire).hide();
					jQuery('#hidden_giver'+desire).show();
				}, 
				error: function(){
					alert('error');
				}
			});

		  });
		  VK.addCallback('onOrderFail', function() {
		    callbacksResults.innerHTML += '<br />onOrderFail';
		  });
		  VK.addCallback('onOrderCancel', function() {
		    callbacksResults.innerHTML += '<br />onOrderCancel';
		  });

	  }
 </script>


<script type="text/javascript">


function DesireUnpublish(key, id){
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->createUrl('desire/unpublish/'); ?>',
		data: {id},
		success: function(data){
			jQuery('#gift_block'+key).slideUp(500);
			jQuery('#recovery_block'+key).fadeIn(500);
		}, 
		error: function(){
			alert('error');
		}
	});
}

function DesireRecovery(key, id){
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->createUrl('desire/recovery/'); ?>',
		data: {id},
		success: function(data){
			jQuery('#gift_block'+key).slideDown(500);
			jQuery('#recovery_block'+key).hide();
		}, 
		error: function(){
			alert('error');
		}
	});
}


function ShowManageLink(key){
	jQuery('#manage_link'+key).fadeIn(500);
	jQuery('#gift_block'+key).mouseleave(function(){
  		jQuery('#manage_link'+key).hide();
	});
}


function ShowAllText(key){
	if (jQuery("#full_text"+key).css("display") == "none"){
		jQuery("#full_text"+key).show();
		jQuery("#text"+key).hide();
	} else {
		jQuery("#full_text"+key).hide();
		jQuery("#text"+key).show();
	}
}


$(document).ready(function() {
/*dotdotdot*/
	$('article').each(function(){
		$(this).find('div').dotdotdot({
			ellipsis: "... ",
			wrap: "word",
			fallbackToLetter: true,
			after: null,
			watch: false,
			height: null,
			tolerance: 0,
			callback: function(isTruncated, orgContent){},
			lastCharacter: {
				remove: [" ", ",", ";", ".", "!", "?"],
				noEllipsis: []
			}
		});
	});

/*tooltip*/
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});

});

function NoDesires(){
        jQuery("#title").focus();
        jQuery("#name_div").addClass('has-error');
        jQuery("#form_panel").addClass('panel-danger');
        jQuery("#no_desires").fadeIn('300');
        setTimeout(function() { 
            jQuery("#name_div").removeClass('has-error');
            jQuery("#form_panel").removeClass('panel-danger');
        }, 600);
        setTimeout(function() { 
            jQuery("#no_desires").fadeOut('300');
        }, 4000);
}

</script>

