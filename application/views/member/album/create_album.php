<div class="col-md-12">
    <div class="row">
        <?php echo form_open_multipart(base_url()."user_album/complete_uploading_album/{$album_id}", "id=fileupload")?>
            <div class="row form-group">
                <div class="col-md-4">
                    <input name="title" type="text" class="form-control" placeholder="Untitled Album..."/>
                </div>
                <div class="col-md-2 btn button-custom fileinput-button" style="background-color: skyblue">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add more photos</span>
                    <input type="file" name="userfile">
                </div>
                <div class="col-md-offset-3 col-md-2">
                    <div id="progress" class="progress" style="width:200px;">
                        <div class="progress-bar progress-bar-success" ></div>
                    </div>
                </div>
            </div>
            <!-- don't remove this blank tag, all files will be stored here -->
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="row col-md-12" style="padding: 15px;border-bottom: 1px solid #CCCCCC; border-top: 1px solid #CCCCCC;">
                        <div id="files">

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12" id="upload">
                    <input type="submit" value="Save & Continue" class="btn button-custom pull-right"/>
                </div>
            </div>
       <?php echo form_close();?>
    </div>

</div>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';

    // Change this to the location of your server-side upload handler:
    var url = '<?php echo base_url()?>user_album/add_photo_in_album/<?php echo $album_id?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                        loadImageMaxFileSize: 20000000, // 20MB
            previewMinHeight: null,
            previewMaxHeight: null,
            previewMinWidth: null,
            previewMaxWidth: null,
            previewThumbnail: false,
            previewCanvas: false,
            previewOrientation: false
        }).on('fileuploadadd', function(e, data) {
            data.context = $("<div class='col-md-3'/>").appendTo('#files');
            //$("div#upload").empty().append(uploadButton.clone(true).data(data));
            $.each(data.files, function(index, file) {
                var node = $('<div/>');
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                var img = $(file.preview).addClass("img-responsive");
                node.append(img);
                node.append("<textarea rows='2' class='form-control' placeholder='Add Description' name='description'/>");
            }
            if (file.error) {
                alert(file.error);
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width',progress + '%');
        }).on('fileuploaddone', function(e, data) {
            $.each($("textarea[name=description]"), function(){
                  $(this).attr("name", "description_" + data.result.photo_id);  
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index, file) {
                //var error = $('<span class="text-danger"/>').text('File upload failed.');
                //$(data.context.children()[index]).append('<br>').append(error);
                alert('File upload failed');
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>