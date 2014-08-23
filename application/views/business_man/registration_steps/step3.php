<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/simpletabs.css">
<div class="col-md-9">
<div class="row new_line">Add business profile image</div>
<div class="row">
    <div class="col-md-4">
        <div class="profile-picture-box" >
            <div id="files" class="files">
                <?php 
                    if ($profile_info != FALSE) { 
                        echo "<img src=" . base_url(). "resources/uploads/business/{$profile_info->logo} class='profile-picture' style='width:120px; height:120px;'/>";
                    } 
                    else
                    {
                        echo "<img src=" . base_url(). "resources/images/your.jpg class='profile-picture' />";
                    }
                    ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Upload a photo</span>
            <input id="fileupload" type="file" name="userfile">
        </div>
        <div class="row">From your computer</div>
        <div id="progress" class="row progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <img src="<?php echo base_url() ?>resources/images/back.png">
        <a id="business_profile_picture_back" href="">Back</a>
    </div>

    <div class="col-md-4 disable_padding_right" id="upload">
        <input type="submit" value="Save & Continue" class="btn button-custom pull-right" onclick="window.location = '<?php echo base_url();?>';"/>
    </div>
</div>
</div>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    $("#business_profile_picture_back").on("click", function(){
        $("#business_profile_step1").removeClass("registration_steps_header_text");
        $("#business_profile_step3").removeClass("registration_steps_header_text");
        $("#business_profile_step2").addClass("registration_steps_header_text");
        kmrSimpleTabs.setStep(1);
        return false;
    });
    // Change this to the location of your server-side upload handler:
    var url = '<?php echo base_url()?>business_profile/upload_logo/',
                    uploadButton = $('<input type="submit" value="Save & Continue"/>').addClass('btn button-custom pull-right').text('Confirm').on('click', function() {
                                    var $this = $(this),data = $this.data();
                                    $this.off('click').text('Abort').on('click', function() {
                                        $this.remove();
                                        data.abort();
                                    });
                                    data.submit().always(function() {
                                        $this.remove();
                                    });
                                });
        
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 120,
            maxNumberOfFiles: 1,
            previewMaxHeight: 120,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            $("#files").empty();
            data.context = $('<div/>').appendTo('#files');
            $("div#upload").empty();
            $("div#upload").append('<br>').append(uploadButton.clone(true).data(data));
            $.each(data.files, function(index, file) {
                var node = $('<p/>');
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node.prepend('<br>').prepend(file.preview);
            }
            if (file.error) {
                $("div#header").append('<br>').append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width',progress + '%');
        }).on('fileuploaddone', function(e, data) {
            window.location = '<?php echo base_url();?>business_profile/show';
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>