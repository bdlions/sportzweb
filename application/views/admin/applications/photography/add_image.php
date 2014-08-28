<script type="text/javascript">
    $(function() {
        /*$('#login_page_image_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#login_page_image_date').text($('#login_page_image_date').data('date'));
            $('#login_page_image_date').datepicker('hide');
        });
        
        $('#logout_page_image_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#logout_page_image_date').text($('#logout_page_image_date').data('date'));
            $('#logout_page_image_date').datepicker('hide');
        });*/
    });
    
</script>
<div class="col-md-10" style="background-color: #F5F5F5">
    <div class="col-md-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 8px;"><!--heading-->
        <div class="panel panel-default">
            <div class="panel-heading">Edit Configuration</div>
            <div class="panel-body">
                <div class="row form-horizontal form-background top-bottom-padding">  
                    <?php echo form_open("admin/applications_photography/add_image", array('id' => 'form_add_image', 'class' => 'form-horizontal', 'onsubmit' => 'return false;'))?>
                    <div class="row">
                        <div class ="col-md-10 margin-top-bottom">                            
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Left Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text1); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Left Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text2); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Middle Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text3); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Middle Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text4); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Right Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text5); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Right Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text6); ?>
                                </div>
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
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
    // Change this to the location of your server-side upload handler:
    var url = "<?php echo base_url();?>admin/applications_photography/add_image",
    uploadButton = $('<input type="submit" value="Save"/>').addClass('btn button-custom pull-right').text('Confirm').
    on('click', function() {
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
        alert(data.result.message);
        window.location = '<?php echo base_url();?>admin/applications_photography/add_image';
    }).on('fileuploadsubmit', function(e, data){
        data.formData = $('#form_add_image').serializeArray();
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