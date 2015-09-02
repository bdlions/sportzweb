<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    window.onload = function()
    {
        CKEDITOR.replace('link', {
            language: 'en',
            toolbar: [
                {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Preview', '-', 'Templates']},
                {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                '/',
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'forms', items: ['ImageButton']},
            ],
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document']}, // Displays document group with its two subgroups.
                {name: 'clipboard', groups: ['clipboard', 'undo']}, // Group's name will be used to create voice label.
                {name: 'links'},
                {name: 'colors'},
                '/', // Line break - next group will be placed in new line.
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'styles'},
                '/',
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                {name: 'forms'},
            ]
        });
    }

</script>

<div class="panel panel-default">
    <div class="panel-heading">Create Reference</div>
    <div class="panel-body">
        <div class="row form-horizontal form-background top-bottom-padding">  
            <form id="formsubmit" method="post" action="<?php echo base_url().'admin/applications_directory/update_app_item_reference/'.$app_item_reference_info['reference_id']; ?>" onsubmit="return false;">
                <div class="row">
                    <div class ="col-md-10 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9"><?php echo $message; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-3 control-label requiredField">
                                Title
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_input($title + array('class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link" class="col-md-3 control-label requiredField">
                                URL
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_textarea($link + array('class' => 'form-control')); ?>
                            </div> 
                            <input type="hidden" name="link_editortext" id="link_editortext">
                        </div>
                        <div class="form-group">
                            <label for="website" class="col-md-3 control-label requiredField">
                                Set News picture
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
                                            <?php if(!empty($app_item_reference_info['img'])): ?>
                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url() . APP_ITEM_REFERENCE_IMAGE_PATH . $app_item_reference_info['img']; ?>" class="img-responsive"/>
                                            <?php endif; ?>
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
            </form>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
<?php $this->load->view("common/ckeditor_customization"); ?>
<script>
    $(function() {
        $("#btnSubmit").on("click", function() {
       
         $("#link_editortext").val(jQuery('<div />').text(CKEDITOR.instances.link.getData()).html());
            if (CKEDITOR.instances.link.getData() === "")
            {
                //alert("Application summary is required .");
                var message = "App url is required .";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url().'admin/applications_directory/update_app_item_reference/'.$app_item_reference_info['reference_id']; ?>',
                data: $("#formsubmit").serializeArray(),
                success: function(data) {
                    var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url(); ?>admin/applications_directory/show_app_item_references';
                }
            });
        });
//    
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url().'admin/applications_directory/update_app_item_reference/'.$app_item_reference_info['reference_id']; ?>',
                  uploadButton = $('<input type="submit" value="Save"/>').addClass('btn button-custom pull-right').text('Confirm').
                    on('click', function() {
                        $("#link_editortext").val(jQuery('<div />').text( filter_html_tags( CKEDITOR.instances.link.getData())).html());
                        if (CKEDITOR.instances.link.getData() === "")
                        {
                           // alert("News heading is required.");
                            var message = "News heading is required.";
                            print_common_message(message);
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
            url:url,
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
            $('#progress .progress-bar').css('width', progress + '%');
        }).on('fileuploaddone', function(e, data) {
            //alert(data.result.message);
            var message = data.result.message;
            print_common_message(message);
            window.location = '<?php echo base_url(); ?>admin/applications_directory/show_app_item_references';
        }).on('fileuploadsubmit', function(e, data) {
            data.formData = $('form').serializeArray();
        }).on('fileuploadfail', function(e, data) {
            //alert(data.message);
            var message = data.message;
            print_common_message(message);
            $.each(data.files, function(index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>

