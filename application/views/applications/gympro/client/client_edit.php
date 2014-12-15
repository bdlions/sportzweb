<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script type="text/javascript">
$(function() {
    $('#start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        startDate: '-3d'
    }).on('changeDate', function(ev) {
        $('#start_date').text($('#start_date').data('date'));
        $('#start_date').datepicker('hide');
    });        
    $('#end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        startDate: '-3d'
    }).on('changeDate', function(ev) {
        $('#end_date').text($('#end_date').data('date'));
        $('#end_date').datepicker('hide');
    });
    $('#birth_date').datepicker({
        dateFormat: 'dd-mm-yy',
        startDate: '-3d'
    }).on('changeDate', function(ev) {
        $('#birth_date').text($('#birth_date').data('date'));
        $('#birth_date').datepicker('hide');
    });
});    

$(function () {
    $("#submit_edit_client").on("click", function(){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url().'applications/gympro/edit_client/'.$client_info['client_id'];?>',
            data: $("#form_edit_client").serializeArray(),
            success: function(data) {
                alert(data.message);
                window.location = '<?php echo base_url().'applications/gympro/manage_clients';?>';
            }
        });
    });
    // Change this to the location of your server-side upload handler:
    var url = "<?php echo base_url().'applications/gympro/edit_client/'.$client_info['client_id'];?>",
    uploadButton = $('<input type="submit" value="Save"/>').text('Confirm').
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
        formData: $("#form_edit_client").serializeArray(),
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
        window.location = '<?php echo base_url().'applications/gympro/manage_clients';?>';
    }).on('fileuploadsubmit', function(e, data){
        data.formData = $('#form_edit_client').serializeArray();
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

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom for this page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">Client Info</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact Details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health Questions</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>
        <div class="col-md-7">
            <div class="pad_title">
                EDIT CLIENT
                <div class="pull-right">
                    <button class="btn button-custom" onclick="open_modal_delete_confirm(<?php echo $client_info['client_id'];?>)">Delete Client</button>
                </div>
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)): ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php echo form_open("applications/gympro/edit_client/".$client_info['client_id'], array('id' => 'form_edit_client', 'class' => 'form-horizontal', 'onsubmit' => 'return false;'))?>
                    <!--Personal details-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">First Name: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($first_name + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Last Name: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($last_name + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Gender </label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('gender_list', $gender_list, $selected_gender_id, 'class=form-control id=gender_list'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($email + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Start Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($start_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">End Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($end_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Birth Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($birth_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Client Status </label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('client_status_list', $client_status_list, $selected_status_id, 'class=form-control id=client_status_list'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Occupation: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($occupation + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Company Name: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($company_name + array('class' => 'form-control'));?>
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
                                                <?php if(!empty($client_info['picture'])): ?>
                                                    <img style="width: 50px; height: 50px;" src="<?php echo base_url() . CLIENT_PROFILE_PICTURE_PATH_W50_H50 . $client_info['picture']; ?>" class="img-responsive"/>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Contact details-->
                    <div class="row hidden_tab" id="contact_details">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Phone: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($phone + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($mobile + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Address: </label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea($address);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency contact: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($emergency_contact + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency phone: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($emergency_phone + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Health questions-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question_info){ ?>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" <?php echo($question_id_answer_map[$question_info['question_id']]['answer'] == 'yes') ? 'checked=""' : '' ;?> name="question_radio_<?php echo $question_info['question_id']?>" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" <?php echo($question_id_answer_map[$question_info['question_id']]['answer'] == 'no') ? 'checked=""' : '' ;?> name="question_radio_<?php echo $question_info['question_id']?>" value="no"> No 
                                    <input type="hidden" value="question_id_<?php echo $question_info['question_id']?>">
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question_info['title']?></label>
                                    </div>
                                    <div style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none' ;?>" style="float: left">
                                        Additional info: 
                                    </div>
                                    <input value="<?php echo $question_id_answer_map[$question_info['question_id']]['additional_info']?>" style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none' ;?>" class="form-control" type="text" id="question_additional_info_<?php echo $question_info['question_id']?>" name="question_additional_info_<?php echo $question_info['question_id']?>">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Height (cm): </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($height + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Resting Heart Rate: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($resting_heart_rate + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Blood Pressure: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($blood_pressure + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Notes-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Notes: </label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea($notes + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div id="upload">
                            <?php echo form_input($submit_edit_client);?>
                            or <a href="<?php echo base_url().'applications/gympro/manage_clients'?>" style="font-size: 16px; line-height: 22px;">Cancel</a>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("applications/gympro/client/client_delete_confirm_modal"); ?>