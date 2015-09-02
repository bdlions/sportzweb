<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    window.onload = function ()
    {
        CKEDITOR.replace('duration', {
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
        }
        );

        CKEDITOR.replace('preparation_method', {
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
        }
        );

        CKEDITOR.replace('ingredients', {
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

<script type="text/javascript">
    /*$(document).ready(function() {
     $("#form_edit_recipe").on("submit", function(){
     $("#duration_editortext").val(jQuery('<div />').text(CKEDITOR.instances.duration.getData()).html());
     $("#ingredients_editortext").val(jQuery('<div />').text(CKEDITOR.instances.ingredients.getData()).html());
     $("#preparation_method_editortext").val(jQuery('<div />').text(CKEDITOR.instances.preparation_method.getData()).html());
     //return false;
     });
     });*/
</script>
<div class="panel panel-default">
    <div class="panel-heading">Edit Recipes</div>
    <div class="panel-body">
        <div class="row form-horizontal form-background top-bottom-padding">  
            <?php echo form_open_multipart("admin/applications_healthyrecipes/edit_recipe/" . $recipes_info['id'], array('id' => 'form_edit_recipe', 'class' => 'form-horizontal', 'onsubmit' => "return false;")); ?>
            <div class="row">
                <div class ="col-md-10 margin-top-bottom">
                    <div class ="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8"><?php echo $message; ?></div>
                        <div class="col-md-8">
                            <?php
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-md-3 control-label requiredField">
                            Reference
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_dropdown('reference_list',$app_item_reference_list, $recipes_info['reference_id'], 'class=form-control id=reference_list'); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-md-3 control-label requiredField">
                            Recipe Title
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($title + array('class' => 'form-control')); ?>
                        </div>
                        <input type="hidden" name="recipe_category_id" value="<?php echo $recipes_info['recipe_category_id']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-md-3 control-label requiredField">
                            Recipe Description
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($description + array('class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="duration" class="col-md-3 control-label requiredField">
                            Recipe Duration
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($duration + array('class' => 'form-control')); ?>
                            <input type="hidden" name="duration_editortext" id="duration_editortext">
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="ingrediantes" class="col-md-3 control-label requiredField">
                            Ingredients
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($ingredients + array('class' => 'form-control')); ?>
                            <input type="hidden" name="ingredients_editortext" id="ingredients_editortext">
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="preparation_method" class="col-md-3 control-label requiredField">
                            Preparation Method
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($preparation_method + array('class' => 'form-control')); ?>
                            <input type="hidden" name="preparation_method_editortext" id="preparation_method_editortext">
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="Recommend_esserts" class="col-md-3 control-label requiredField">
                            Recommend Desserts
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($recommend_resserts + array('class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_recommand_recipe')); ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="Alternative_recipes" class="col-md-3 control-label requiredField">
                            Alternative Recipes
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($alternative_recipes + array('class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_alternative_recipe')); ?>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="website" class="col-md-6 control-label requiredField">
                            Set Service picture
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

                            <div class=" col-md-6">
                                <div class="profile-picture-box" >
                                    <div id="files" class="files">
                                        <img style="width: 120px; height: 120px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $image; ?>" class="img-responsive"/>
                                        <br>
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
            <?php echo form_close(); ?>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>

<?php $this->load->view("common/ckeditor_customization"); ?>

<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        $("#btnSubmit").on("click", function () {
            $("#duration_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.duration.getData())).html());
            $("#ingredients_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.ingredients.getData())).html());
            $("#preparation_method_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.preparation_method.getData())).html());
            if ($("#title").val().length == 0)
            {
                //alert("Name of recipe is required.");
                var message = "Name of recipe is required.";
                print_common_message(message);
                return;
            } else if ($("#description").val().length == 0)
            {
               // alert("Recipe description is required.");
               var message = "Recipe description is required.";
                print_common_message(message);
                return;
            } else if (CKEDITOR.instances.duration.getData() === "")
            {
                //alert("Duration of recipe is required.");
                var message = "Duration of recipe is required.";
                print_common_message(message);
                return;
            } else if (CKEDITOR.instances.ingredients.getData() === "")
            {
                //alert("Ingrediantes of recipe is required.");
                var message = "Ingrediantes of recipe is required.";
                print_common_message(message);
                return;
            }
            else if (CKEDITOR.instances.preparation_method.getData() === "")
            {
                //alert("Preparation method of recipe is required.");
                var message = "Preparation method of recipe is required.";
                print_common_message(message);
                return;
            }

            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>admin/applications_healthyrecipes/edit_recipe/<?php echo $recipes_info['id']; ?>',
                                data: $("#form_edit_recipe").serializeArray(),
                                success: function (data) {
                                    //alert(data.message);
                                   var message = data.message;
                                   print_common_message(message);
                                    window.location = '<?php echo base_url(); ?>admin/applications_healthyrecipes/recipe_category/<?php echo $recipes_info['recipe_category_id']; ?>';
                                                    }
                                                });
                                            });

                                            // Change this to the location of your server-side upload handler:
                                            var url = "<?php echo base_url(); ?>admin/applications_healthyrecipes/edit_recipe//<?php echo $recipes_info['id']; ?>",
                                                            uploadButton = $('<input type="submit" value="Update"/>').addClass('btn button-custom pull-right').text('Confirm').
                                                            on('click', function () {
                                                                $("#duration_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.duration.getData())).html());
                                                                $("#ingredients_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.ingredients.getData())).html());
                                                                $("#preparation_method_editortext").val(jQuery('<div />').text(filter_html_tags(CKEDITOR.instances.preparation_method.getData())).html());
                                                                if ($("#title").val().length == 0)
                                                                {
                                                                  //  alert("Name of recipe is required.");
                                                                 var message = "Name of recipe is required.";
                                                                 print_common_message(message);
                                                                    return;
                                                                } else if ($("#description").val().length == 0)
                                                                {
                                                                   // alert("Recipe description is required.");
                                                                   var message = "Recipe description is required.";
                                                                   print_common_message(message);
                                                                    return;
                                                                } else if (CKEDITOR.instances.duration.getData() === "")
                                                                {
                                                                    //alert("Duration of recipe is required.");
                                                                    var message = "Duration of recipe is required.";
                                                                   print_common_message(message);
                                                                    return;
                                                                } else if (CKEDITOR.instances.ingredients.getData() === "")
                                                                {
                                                                   // alert("Ingrediantes of recipe is required.");
                                                                   var message = "Ingrediantes of recipe is required.";
                                                                   print_common_message(message);
                                                                    return;
                                                                }
                                                                else if (CKEDITOR.instances.preparation_method.getData() === "")
                                                                {
                                                                   // alert("Preparation method of recipe is required.");
                                                                   var message = "Preparation method of recipe is required.";
                                                                   print_common_message(message);
                                                                    return;
                                                                }

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
                                                        //console.log(data);
                                                       // alert(data.result.message);
                                                       var message = data.result.message;
                                                       print_common_message(message);
                                                        window.location = '<?php echo base_url(); ?>admin/applications_healthyrecipes/recipe_category/<?php echo $recipes_info['recipe_category_id']; ?>';
                                                                    //console.log(data);
                                                                }).on('fileuploadsubmit', function (e, data) {
                                                                    data.formData = $('form').serializeArray();
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

<style>
    .hidden_upload_area {
        height: 0;
        overflow: hidden;
        visibility: hidden;
        width: 0;
    }
</style>
<script type="text/javascript">
//FUNCTION FOR SELECT THE INPUT TYPE FILE FIELD
    /*function sentIDvalue(id_name)
     {
     $('#'+id_name).click();
     }
     document.getElementById('browse_your_file').onchange = function () {
     //alert('Selected file: ' + this.value);
     $('#show_file_name').show().html(this.value);
     }; */
</script>

<?php $this->load->view("admin/applications/healthy_recipes/modal_recommand_recipe"); ?>
<?php $this->load->view("admin/applications/healthy_recipes/modal_alternative _recipe"); ?>
<?php $this->load->view("common/common_modal"); ?>

