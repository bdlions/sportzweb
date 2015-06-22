<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    $(function() {
        $("#submit_edit_exercise").on("click", function() {
            if($("#client_list").val() == 0)
            {
                //alert("Please select the person you are assessing from the drop menu.");
                var message = "Please select the person you are assessing from the drop menu.";
                 print_common_message(message);
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url() . 'applications/gympro/edit_exercise/' . $exercise_info['exercise_id']; ?>',
                data: $("#form_exercise_edit").serializeArray(),
                success: function(data) {
                    //alert(data.message);
                 var message = data.message;
                 print_common_message(message);
                    window.location = '<?php echo base_url() . 'applications/gympro/manage_exercises'; ?>';
                }
            });
        });
        // Change this to the location of your server-side upload handler:
        var url = "<?php echo base_url() . 'applications/gympro/edit_exercise/' . $exercise_info['exercise_id']; ?>",
        uploadButton = $('<input type="submit" value="Save"/>').text('Confirm').
        on('click', function() {
            var $this = $(this), data = $this.data();
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
            formData: $("#form_exercise_edit").serializeArray(),
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
            window.location = '<?php echo base_url() . 'applications/gympro/manage_exercises'; ?>';
        }).on('fileuploadsubmit', function(e, data) {
            data.formData = $('#form_exercise_edit').serializeArray();
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
<div class="container-fluid">    
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-10">
            <?php echo form_open("applications/gympro/edit_exercise/".$exercise_info['exercise_id'], array('id' => 'form_exercise_edit', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')) ?>
            <div class="pad_title">
                EDIT EXERCISE
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Category:*
                            </div>
                            <div class="col-md-6">
                                <?php echo form_dropdown('exercise_category_list', $exercise_category_list, $selected_exercise_category_id, 'class=form-control id=exercise_category_list'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Title:*
                            </div>
                            <div class="col-md-6">
                                <?php echo form_input($name + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Description:
                            </div>
                            <div class="col-md-8">
                                <?php echo form_textarea($description + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="website" class="col-md-4 control-label requiredField">
                                Set picture
                            </label>
                            <div class ="col-md-8">
                                <div class="col-md-9">
                                    <div class="row fileinput-button">
                                        <button class="btn button-custom">Upload a photo</button>
                                        <input id="fileupload" type="file" name="userfile">
                                    </div>
                                    <div id="progress" class="row progress" style="margin-top: 8px;">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="profile-picture-box" >
                                        <div id="files" class="files">
                                            <?php if (!empty($exercise_info['picture'])): ?>
                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url() . EXERCISE_IMAGES_PATH_W50_H50 . $exercise_info['picture']; ?>" class="img-responsive"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="upload" class="pad_footer">
                    <?php echo form_input($submit_edit_exercise); ?>
                    or <a href="<?php echo base_url() . 'applications/gympro/manage_exercises' ?>" style="font-size: 16px; line-height: 22px;">Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>