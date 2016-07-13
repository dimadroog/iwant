/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */
function RemoveValueFile(){
    jQuery('.upload_container').show();
    jQuery('#preview_div').html('<img id="preview"><a id="preview_link" onclick="RemoveValueFile()"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
    jQuery('#without_file').show();
    jQuery('#with_file').hide();
}


// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};


// check for selected crop region
function checkForm() {
    if (jQuery('#title').val() == ''){
        jQuery("#title").focus();
        jQuery("#name_div").addClass('has-error');
        setTimeout(function() { 
            jQuery("#name_div").removeClass('has-error');
        }, 600);
        return false;
    } else {  
        return true;
    }
};


// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    var koeff = jQuery('#koeff').val();
    $('#x1').val(e.x*koeff);
    $('#y1').val(e.y*koeff);
    $('#x2').val(e.x2*koeff);
    $('#y2').val(e.y2*koeff);
    $('#w').val(e.w*koeff);
    $('#h').val(e.h*koeff);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};

function fileSelectHandler() {
    var src = jQuery('#preview').attr('src');
    if (src != '') {
        jQuery('#preview_link').show();
        jQuery('.upload_container').hide();
    };
    jQuery('#without_file').hide();
    jQuery('#with_file').fadeIn('slow');

    // get selected file
    var oFile = $('#image_file')[0].files[0];


    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/gif)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg, gif and png are allowed)').show();
        return;
    }

    // check for file size
    // if (oFile.size > 250 * 1024) {
    //     $('.error').html('You have selected too big file, please select a one smaller image file').show();
    //     return;
    // }

    // preview element
    var oImage = document.getElementById('preview');


    // prepare HTML5 FileReader
    var oReader = new FileReader();


    

        oReader.onload = function(e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
            


            // display step 2
            $('#step2').fadeIn(500);


            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);


            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            // $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // if (oImage.naturalWidth > 300) {
            //     var koeff = oImage.naturalWidth/300;
            // } else {
            //     var koeff = 1;    
            // }
            // jQuery('#koeff').val(koeff);    

            var koeff = oImage.naturalWidth/300;
            jQuery('#koeff').val(koeff);    


            // Create variables (in this scope) to hold the Jcrop API and image size
            var jcrop_api, boundx, boundy;

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') 
                jcrop_api.destroy();


            // initialize Jcrop
            $('#preview').Jcrop({
                minSize: [30, 30], // min crop size
                aspectRatio : 1, // keep aspect ratio 1:1
                bgFade: true, // use fade effect
                bgOpacity: .3, // fade opacity
                onChange: updateInfo,
                onSelect: updateInfo,
                setSelect: [ 20, 300, 300, 20 ],
                onRelease: clearInfo
            }, function(){

                // use the Jcrop API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];

                // Store the Jcrop API in the jcrop_api variable
                jcrop_api = this;
            });
        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

