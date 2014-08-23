<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>'+'admin/footer/update_image/<?php echo $image_region_id?>';

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB                 // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewCanvas: false,
            previewMaxWidth: 208,
            maxNumberOfFiles: 1,
            previewMaxHeight: 208,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            //$("#files").empty();
            data.context = $('<li class="col-md-3" style="padding-bottom:10px"/>').appendTo('#files');
            //$("div#upload").empty();
            //$("div#upload").append('<br>').append(uploadButton.clone(true).data(data));
            $.each(data.files, function(index, file) {
                var node = $('<div />');
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {                     node.prepend('<br>').prepend(file.preview);
            }
            if (file.error) {
                //$("div#header").append('<br>').append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                //console.log(progress);
                $('#progress .progress-bar').css('width',progress + '%');             
            }).on('fileuploaddone', function(e, data) {
                $('.progress').removeClass('active');
                $('#progress .progress-bar').removeAttr('style'); 
                //alert(data.result.message);
                window.location.href='<?php echo base_url().'admin/footer/about_us' ?>'
                }).on('fileuploadfail', function(e, data) {
                        $.each(data.files, function(index, file) {
                            //var error = $('<span class="text-danger"/>').text('File upload failed.');
                            //$(data.context.children()[index]).append('<br>').append(error);
                        });
                    }).prop('disabled', !$.support.fileInput)
                            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
<div class="col-md-10" style="background-color: #F5F5F5">
    <div class="col-md-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 8px;"><!--heading-->
        <div class="panel panel-default">
            <div class="panel-heading">Edit Configuration</div>
            <div class ="row">
                <div class="col-md-3"></div>
                <div class="col-md-9" style="padding-top: 10px;"><?php echo isset($message) ? $message : ""; ?></div>
            </div>
            <div class="panel-body">
                <div class="row form-horizontal form-background top-bottom-padding">  
                   
                    <div class="row">
                        <div class ="col-md-10 margin-top-bottom">
                            
                            <div class="form-group">
                            <label for="website" class="col-md-3 control-label requiredField">
                                Set updated picture:
                            </label>
                            <div class ="col-md-6">
                                <div class="col-md-6">
                                    <div class="row fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Upload a photo</span>
                                        <input id="fileupload" type="file" name="userfile">
                                    </div>
                                    <div id="progress" class="row progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>