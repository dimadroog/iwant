        <meta charset="utf-8" />
        <title>HTML5 Загрузка и обрезка изображений </title>

        <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

        <script src="js/jquery.Jcrop.min.js"></script>
        <script src="js/script.js"></script>



        
            

                <!-- upload form -->
                <!-- <form id="upload_form" enctype="multipart/form-data" method="post" action=""> -->
                <!-- <form id="upload_form" enctype="multipart/form-data" method="post" action="dd.php"> -->
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upload.php">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />


                    <div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>

                    <div class="error"></div>

                    <div id="step2" style="display:none">
                        <img id="preview" />
<br><br>
                        <div class="info">
                            <label>Размер файла: </label> <input type="text" id="filesize" name="filesize" />
                            <label>Тип: </label> <input type="text" id="filetype" name="filetype" />
                            <label>Размер изображения</label> <input type="text" id="filedim" name="filedim" /><br><br>
                            <label>W</label> <input type="text" id="w" name="w" /><br><br>
                            <label>H</label> <input type="text" id="h" name="h" /><br><br>
                        </div>

                        <!-- <input type="submit" class="button default" value="Обрезать и загрузить"> -->
                        <input type="submit" class="button default" value="Обрезать и загрузить"  onclick="return checkForm()">
                        <!-- <a onclick="subm()">subm</a> -->
                    </div>
                </form>
            

<!-- 
<script type="text/javascript">
function subm(){
    // checkForm();
    jQuery.ajax({
        url: 'upload.php',
        // url: 'dd.php',
        type: "POST", //Тип запроса
        data: jQuery("#upload_form").serialize(),
        success: function (data) {
            alert(data);
        },
        error:  function (data) {
           alert('err');
        }                    
    });
}
</script>   
 -->
