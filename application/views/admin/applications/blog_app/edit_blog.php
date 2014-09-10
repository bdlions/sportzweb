<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    window.onload = function()
    {
        CKEDITOR.replace('title', {
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


        CKEDITOR.replace('description', {
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
        
        CKEDITOR.replace('image_description', {
        language: 'en',
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },

        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        '/',
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
        { name: 'forms', items: ['ImageButton'] },
        ],
        toolbarGroups: [
                { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
        { name: 'links' },
        { name: 'colors' },
                '/',																// Line break - next group will be placed in new line.
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'styles' },
        '/',
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'forms' },
        ]
    });
    }
</script>

<div class="panel panel-default">
    <div class="panel-heading">Edit Blog</div>
    <div class="panel-body">
        <div class="row form-horizontal form-background top-bottom-padding">  
            <form id="formsubmit" method="post" action="<?php echo base_url(); ?>admin/applications_blogs/edit_blog/<?php echo $blog_id; ?>" onsubmit="return false;">
                <div class="row">
                    <div class ="col-md-10 margin-top-bottom">
                        <div class ="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9"><?php echo $message; ?></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label requiredField">
                                Blog Category
                            </label>
                            <div class ="col-md-9">
                                <?php
                                    if(!empty($category_list)){
                                        $total_length = count($category_list);
                                        for ($i = 1; $i <= $total_length; ) {
                                            echo '<div class="row">';
                                            for($j = $i; $j < ($i + NO_OF_COLLUMN) && ($j<=$total_length) ; $j++ ){
                                                echo '<div class="col-md-4">';

                                                if($category_list[$j]['checked'] == 1)
                                                {
                                                    echo '<input checked="checked" class="category_id" name="category_name[]" type="checkbox" id="'.$category_list[$j]["id"].'" value="'.$category_list[$j]["id"].'"/>';
                                                } else
                                                {
                                                    echo '<input class="category_id" name="category_name[]" type="checkbox" id="'.$category_list[$j]["id"].'" value="'.$category_list[$j]["id"].'"/>';
                                                }
                                                
                                                echo '<label style="padding-left:10px;" for="type" class=" control-label requiredField">'.$category_list[$j]["title"].'</label>';
                                                echo "</div>";
                                            }
                                            $i = $j;
                                            echo "</div>";
                                        }
                                    }  
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label requiredField">
                                Blog Title
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_textarea($title + array('class' => 'form-control')); ?>
                                <input type="hidden" name="title_editortext" id="title_editortext">
                                <input type="hidden" name="blog_id" id="blog_id" value="<?php echo $blog_id; ?>">
                            </div> 
                        </div>


                        <div class="form-group">
                            <label for="description" class="col-md-3 control-label requiredField">
                                Description
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_textarea($description + array('class' => 'form-control')); ?>
                            </div>
                            <input type="hidden" name="description_editortext" id="description_editortext">
                        </div>

                        <div class="form-group">
                            <label for="Related Blogs" class="col-md-3 control-label requiredField">
                                Related Blogs
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_input($related_blogs + array('class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_related_blogs')); ?>
                            </div> 
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="col-md-3 control-label requiredField">
                                Image Description
                            </label>
                            <div class ="col-md-9">
                                <?php echo form_textarea($image_description + array('class' => 'form-control')); ?>
                            </div>
                            <input type="hidden" name="image_description_editortext" id="image_description_editortext">
                        </div>

                        <div class="form-group">
                            <label for="website" class="col-md-3 control-label requiredField">
                                Set Blog picture:
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
                                            <?php if (!empty($blog_info['picture'])): ?>
                                                <img style="width: 120px; height: 120px;" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_info['picture']; ?>" class="img-responsive"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-offset-8 col-md-4 disable_padding_right" id="upload">
                                    <input id="btnSubmit" type="submit" value="Update" class="btn button-custom pull-right"/>
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
<?php $this->load->view("admin/applications/blog_app/modal_related_blogs"); ?>
<script>
    $(function() {
        $("#btnSubmit").on("click", function() {
            //var blog_category_id = $('#dropdown').val();
            //$('#blog_category_id').val(blog_category_id);
            $("#title_editortext").val(jQuery('<div />').text(CKEDITOR.instances.title.getData()).html());
            $("#description_editortext").val(jQuery('<div />').text(CKEDITOR.instances.description.getData()).html());
            $("#image_description_editortext").val(jQuery('<div />').text(CKEDITOR.instances.image_description.getData()).html());
            if (!$('.category_id').is(':checked')) {
                alert("Checked atleast one blog category");
                return;
            }
            else if (CKEDITOR.instances.title.getData() === "")
            {
                alert("Blog heading is required.");
                return;
            }
            else if (CKEDITOR.instances.description.getData() === "")
            {
                alert("Blog description is required.");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>admin/applications_blogs/edit_blog/<?php echo $blog_id; ?>',
                data: $("#formsubmit").serializeArray(),
                success: function(data) {
                    alert(data.message);
                    window.location = '<?php echo base_url(); ?>admin/applications_blogs/edit_blog/<?php echo $blog_id; ?>';
                    }
                });
            });

                            // Change this to the location of your server-side upload handler:
    var url = "<?php echo base_url(); ?>admin/applications_blogs/edit_blog/<?php echo $blog_id; ?>",
            uploadButton = $('<input type="submit" value="Update"/>').addClass('btn button-custom pull-right').text('Confirm').
            on('click', function() {
                $("#title_editortext").val(jQuery('<div />').text(CKEDITOR.instances.title.getData()).html());
                $("#description_editortext").val(jQuery('<div />').text(CKEDITOR.instances.description.getData()).html());
                $("#image_description_editortext").val(jQuery('<div />').text(CKEDITOR.instances.image_description.getData()).html());
                if (!$('.category_id').is(':checked')) {
                    alert("Checked atleast one blog category");
                    return;
                }
                else if (CKEDITOR.instances.title.getData() === "")
                {
                    alert("Blog heading is required.");
                    return;
                }
                else if (CKEDITOR.instances.description.getData() === "")
                {
                    alert("Blog description is required.");
                    return;
                }
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
                alert(data.result.message);
                window.location = '<?php echo base_url(); ?>admin/applications_blogs/edit_blog/<?php echo $blog_id; ?>';
            }).on('fileuploadsubmit', function(e, data) {
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