<div class="col-md-10" style="background-color: #F5F5F5;" id="upload_image_panel">
    <div class="panel panel-default">
        <div class="panel-heading">Background Landing Image</div>
        <div class="panel-body">
            <div class="row form-horizontal form-background top-bottom-padding">  
                <div class="row">
                    <div class ="col-md-10 margin-top-bottom"> 
                        <div class="form-group">
                            <label class="col-lg-offset-1 col-md-offset-1 col-xs-offset-1 col-sm-offset-1">Please upload an image at least Height: 781px [Image 683px + 98px black section in bottom] and Width: 1349px for better resolution</label>
                        </div>
                        <div class="form-group">
                            <label for="website" class="col-md-3 control-label requiredField">
                                Set picture
                            </label>
                            <div class ="col-md-9">
                                <div class="col-md-9">
                                    <div class="row fileinput-button">
                                        <button class="btn button-custom">Upload a photo</button>
                                        <input id="fileupload" type="file" name="userfile">
                                    </div>
                                    <div id="progress" class="row progress" style="margin-top: 8px;">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="profile-picture-box" >
                                        <div id="files" class="files">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-offset-8 col-md-4 disable_padding_right" id="upload">
                                    <input id="btnSubmit" type="submit" value="Save" class="btn button-custom pull-right"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        // Change this to the location of your server-side upload handler:
        var url = "<?php echo base_url(); ?>admin/bg_landing_img/add_image",
                uploadButton = $('<input type="submit" value="Save"/>').addClass('btn button-custom pull-right').text('Confirm').
                on('click', function () {
                    var $this = $(this), data = $this.data();
                    $this.off('click').text('Abort').on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });

        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: $("#form_add_image").serializeArray(),
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
        }).on('fileuploadadd', function (e, data) {
            $("#files").empty();
            data.context = $('<div/>').appendTo('#files');
            $("div#upload").empty();
            $("div#upload").append('<br>').append(uploadButton.clone(true).data(data));
            $.each(data.files, function (index, file) {
                var node = $('<p/>');
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
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
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }).on('fileuploaddone', function (e, data) {
            // alert(data.result.message);
            var message = data.result.message;
            print_common_message(message);
            window.location = '<?php echo base_url(); ?>admin/bg_landing_img/';
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = $('#form_add_image').serializeArray();
        }).on('fileuploadfail', function (e, data) {
            // alert(data.message);
            var message = data.message;
            print_common_message(message);
            $.each(data.files, function (index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>
