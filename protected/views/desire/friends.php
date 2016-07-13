<h3>Желания Ваших друзей </h3>
<h4>Узнайте, чего хотят Ваши друзья в подарок</h4>
<p><a onclick="invite()">Пригласить друзей</a></p>
		
<?php foreach ($friends as $key => $friend): ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<?php //foreach (User::get_user_info($friend->user_id) as $friend_info): ?>
					<div class="col-xs-2">
						<a href="http://vk.com/id<?php echo $friend->user_id; ?>" target="_blank"><img src="<?php echo $friend->photo_50; ?>"></a>
					</div>
					<div class="col-xs-10">
						<a href="http://vk.com/id<?php echo $friend->user_id; ?>" target="_blank"><h4><?php echo $friend->first_name.' '.$friend->last_name; ?></h4></a>
					</div>
				<?php // endforeach; ?> 
				<div class="col-xs-10">
				<a onclick="ShowFriendDesires(<?php echo $friend->id; ?>)" id="desires_link<?php echo $key; ?>">Желаний: <?php echo Desire::get_publish_desires_count($friend->id); ?></a>
				</div>
			</div>



			<div class="" id="friend_desires<?php echo $friend->id; ?>" style="display:none">
				

				<?php foreach (Desire::get_publish_desires($friend->id) as $desire): ?>

					<div class="row gift-block" id="gift_block<?php echo $desire->id;?>">

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

							<span class="desire-title" onclick="ShowAllText(<?php echo $desire->id;?>)">
								<?php echo $desire->title; ?>
							</span>

							<?php if ($desire->text): ?>

								<article>

									<div class="text_review" id="text<?php echo $desire->id;?>" onclick="ShowAllText(<?php echo $desire->id;?>)">
										 <?php echo nl2br(strip_tags($desire->text)); ?>
									</div>

								</article>

								<div class="text_full" id="full_text<?php echo $desire->id;?>" onclick="ShowAllText(<?php echo $desire->id;?>)" style="display:none">
								 	<?php echo nl2br(strip_tags($desire->text)); ?>
								</div>

							<?php else: ?>

								<div style="height: 28px;"></div>

							<?php endif; ?>

							<div class="text-right" style="margin-top: 7px;" id="button_desire<?php echo $desire->id; ?>">
								<?php if($desire->giver_id == 0): ?>
									<div class="btn btn-primary" onclick="IWillGive(<?php echo $desire->id; ?>)">
										Я подарю
									</div> 
								<?php elseif($desire->giver_id == Yii::app()->user->id): ?>
									<div class="btn btn-danger" onclick="IWillNotGive(<?php echo $desire->id; ?>)">
										Я передумал
									</div> 
								<?php elseif($desire->giver_id != 0 && $desire->giver_id != Yii::app()->user->id ): ?>
									<div class="btn btn-default" disabled="disabled">
										Уже занято кем-то
									</div> 
								<?php endif; ?>
							</div>

						</div>


					</div>
				<?php endforeach; ?>



				<div class="text-center"><a onclick="ShowFriendDesires(<?php echo $friend->id; ?>)">Скрыть</a></div>


			</div>
		</div>
	</div>

<?php endforeach; ?>



<script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script>

 <script type="text/javascript">

	function invite() {
	    VK.callMethod('showInviteBox');
	}
 </script>



<script type="text/javascript">

	function ShowFriendDesires(friend){
		if (jQuery('#friend_desires'+friend).css('display') == 'none') {
			jQuery('#friend_desires'+friend).slideDown(500);
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
		} else {
			jQuery('#friend_desires'+friend).slideUp(500);
		}
	}


	function ShowAllText(id){
		if (jQuery("#full_text"+id).css("display") == "none"){
			jQuery("#full_text"+id).show();
			jQuery("#text"+id).hide();
		} else {
			jQuery("#full_text"+id).hide();
			jQuery("#text"+id).show();
		}
	}


	$(document).ready(function() {
		/*tooltip*/
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		});
	});

	function IWillGive(desire){
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl('desire/setgiver/'); ?>',
			data: {desire},
			success: function(data){
				var other_button = '<div class="btn btn-danger" onclick="IWillNotGive('+desire+')">Я передумал</div> ';
				jQuery('#button_desire'+desire).html(other_button);
			}, 
			error: function(){
				alert('error');
			}
		});
	}

	function IWillNotGive(desire){
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl('desire/deletegiver/'); ?>',
			data: {desire},
			success: function(data){
				var other_button = '<div class="btn btn-primary" onclick="IWillGive('+desire+')">Я подарю</div> ';
				jQuery('#button_desire'+desire).html(other_button);
			}, 
			error: function(){
				alert('error');
			}
		});
	}

</script>	 	