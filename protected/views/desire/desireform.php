<?php /**
 * This is the model class for table "desire".
 *
 * The followings are the available columns in table 'desire':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property integer $paid
 * @property integer $giver_id
 * @property string $img
 */ ?>

<div class="panel panel-default" id="form_panel">
    <div class="panel-body">

        <form id="upload_form" enctype="multipart/form-data" method="post" action="<?php echo Yii::app()->createUrl('desire/upload') ?>">

                <!-- hidden crop params -->
               <input type="hidden" id="x1" name="x1">
               <input type="hidden" id="y1" name="y1">
               <input type="hidden" id="x2" name="x2">
               <input type="hidden" id="y2" name="y2">
               <input type="hidden" id="w" name="w">
               <input type="hidden" id="h" name="h">
               <input type="hidden" id="koeff" name="koeff">
                <!-- hidden crop params -->
                <input type="hidden" name="user_id" value="<?php echo $_GET['viewer_id']; ?>">
                <input type="hidden" name="giver_id" value="0">



			<div id="name_div" class="form-group">
				<label>Ваше желание</label>
				<input name="title" type="text" class="form-control" id="title">
				<!-- <div class="text-right"><a onclick="ShowDescr()">Подробнее?</a></div> -->
			</div>
				<div id="show_descr" style="display:none">
					<div class="form-group">
						<textarea id="text" name="text" class="form-control" rows="3" placeholder="Опишите подробнее Ваше желание"></textarea>
					</div> 					
					<div class="form-group">
						<div class="upload_container upload">
						    <span class="btn">Загрузить фото</span>
						    <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" />
						</div>
					</div> 




					<div class="error"></div>


					<div id="preview_div">


						<img id="preview" />
						
						<a id="preview_link" onclick="RemoveValueFile()"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
					</div>

					<br>

				</div> 


			<input style="display:none" id="with_file" type="submit" class="btn btn-default" value="Обрезать и добавить" onclick="return checkForm()">
			<input id="without_file" type="submit" class="btn btn-default" value="Добавить желание" onclick="return checkForm()">
			<div style="float:right"><a id="link_show_descr" onclick="ShowDescr()" class="text-right">Подробнее?</a></div>

		</form>
    </div>        
</div>        






<script type="text/javascript">
    function ShowDescr() {
        jQuery('#show_descr').toggle(300);
        if (jQuery('#link_show_descr').html() == 'Свернуть'){
        	jQuery('#link_show_descr').html('Подробнее?');
        } else if (jQuery('#link_show_descr').html() == 'Подробнее?'){
        	jQuery('#link_show_descr').html('Свернуть');
        }

    }
 </script>




