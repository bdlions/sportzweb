<div class="panel panel-default">
    <div class="panel-heading">Edit Service Category</div>
    <div class="panel-body">
        <div class="row form-horizontal form-background top-bottom-padding">  
            <form id="formsubmit" method="post" action="<?php echo base_url(); ?>admin/servicedirectory/edit_service_category/<?php echo $service_category_id; ?>" onsubmit="return false;">
                <div class="row">
                    <div class ="col-md-10 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><?php echo $message; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-6 control-label requiredField">
                                Service Category Name
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($title + array('class' => 'form-control')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="website" class="col-md-6 control-label requiredField">
                                Set Service Category picture
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

                                <div class=" col-md-4">
                                    <div class="profile-picture-box" >
                                        <div id="files" class="files">
                                            <img style="width: 35px; height: 35px;" src="<?php echo base_url() . SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH . $service_category_info['picture']; ?>" class="img-responsive"/>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-offset-8 col-md-4 disable_padding_right" id="upload">
                                    <input id="btnSubmit" type="submit" value="Update" class="btn button-custom pull-right"/>
                                </div>
                            </div>
                            <div class ="col-md-6">
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    $("#btnSubmit").on("click", function(){
        if ($("#title").val().length == 0)
        {
            alert("Title of service category is required.");
            return;
        }
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>admin/servicedirectory/edit_service_category/<?php echo $service_category_id; ?>',
            data: $("#formsubmit").serializeArray(),
            success: function(data) {
                alert(data.message);
                window.location = '<?php echo base_url();?>admin/servicedirectory/edit_service_category/<?php echo $service_category_id; ?>';
            }
        });
    });
    
    // Change this to the location of your server-side upload handler:
    var url = "<?php echo base_url();?>admin/servicedirectory/edit_service_category/<?php echo $service_category_id; ?>",
                    uploadButton = $('<input type="submit" value="Update"/>').addClass('btn button-custom pull-right').text('Confirm').
                    on('click', function() {
                                    if ($("#title").val().length == 0)
                                    {
                                        alert("Title of service category is required.");
                                        return;
                                    }
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
            formData: $("form").serializeArray(),
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
            console.log(data);
            alert(data.result.message);
            window.location = '<?php echo base_url();?>admin/servicedirectory/edit_service_category/<?php echo $service_category_id; ?>';
            //console.log(data);
        }).on('fileuploadsubmit', function(e, data){
            data.formData = $('form').serializeArray();
        }).on('fileuploadfail', function(e, data) {
            alert(data.message);
            $.each(data.files, function(index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>