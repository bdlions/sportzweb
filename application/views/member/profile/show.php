<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/member.css">

<script type="text/javascript">
    function open_modal_unfollow_confirm(follower_id){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_unfollow_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info)); 
                $('#span_unfollow_confirm_message').text('Unfollow '+data.user_info.first_name+' '+data.user_info.last_name+'?');
                $('#follower_id_confirm_unfollow').val(follower_id);
                $('#modal_unfollow_confirm').modal('show');
            }
        });
        //$('#follower_id_confirm_unfollow').val(follower_id);
        //$('#modal_unfollow_confirm').modal('show');
    }
    
    function open_modal_block_confirm(follower_id){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_block_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info)); 
                $('#span_block_confirm_message').text('Block '+data.user_info.first_name+' '+data.user_info.last_name+'?');
                $('#follower_id_confirm_block').val(follower_id);
                $('#modal_block_confirm').modal('show');
            }
        });
        
        //$('#follower_id_confirm_block').val(follower_id);
        //$('#modal_block_confirm').modal('show');
    }
    
    function open_modal_report(follower_id){
        $('#follower_id').val(follower_id);
        $('#<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>').attr('checked', false);
        $('#<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>').attr('checked', false);
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_follower_info").html(tmpl("tmpl_user_info", data.user_info)); 
                $('#span_shared_content').text('Report content shared by '+data.user_info.first_name+' '+data.user_info.last_name);
                $('#modal_report_content').modal('show');
            }
        });

    }
    
    $(function() {
        $("#button_user_follow").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>followers/add_follower/' + <?php echo $user_id ?>,
                dataType: 'json',
                success: function(data) {
                    if (data == true) {
                        window.location.reload();
                    }
                    else {
                      //  alert("error for following users.");
                       var message = "error for following users.";
                    print_common_message(message);
                    }
                }
            });
        });
        
        $("#button_unblock").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/unblock_follower",
                data: {
                    follower_id: '<?php echo $user_id ?>'
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
        
        $("#button_accept_request").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/accept_follower",
                data: {
                    follower_id: '<?php echo $user_id ?>'
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
    });

    function imgupload(imgplace)
    {
        <?php if (is_myself($user_id)) { ?>
        
            $('#files').html('');
            $('#img_place').val(imgplace);
            $('#modal_share_service').modal('show');
        <?php } ?>
    }

    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url();?>member_profile/upload_photo_on_list';

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
            $("#files").empty();
            data.context = $('<li class="col-md-3 form-group"/>').appendTo('#files');
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
            if (file.preview) {
                node.prepend('<br>').prepend(file.preview);
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
            $('#progress .progress-bar').css('width', progress + '%');
        }).on('fileuploaddone', function(e, data) {
            $('.progress').removeClass('active');
            //$('#progress .progress-bar').removeAttr('style');
            $('#progress .progress-bar').css('width','100%');
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index, file) {
                //var error = $('<span class="text-danger"/>').text('File upload failed.');
                //$(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>

<!-- Modal -->
<div class="modal fade" id="modal_share_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Upload Photo</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php //echo form_open_multipart('member_profile/upload_photo_on_list'); ?>
                        <form action="<?php echo base_url();?>member_profile/upload_photo_on_list"  method="post" onsubmit="return false">
                        <ul class="list-inline list-unstyled row files">
                            <div class="col-md-3">
                                <div class="fileinput-button">
                                    <img class="img-responsive" src="<?php echo base_url() ?>resources/images/add_photo_album.jpg" alt="">
                                    <input id="fileupload" type="file" name="userfile">
                                </div>
                            </div>
                            <div class="col-md-9" id="files">
                            </div>
                        </ul>
                        <div id="progress" class="progress col-md-12">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <input type="hidden" id="img_place" name="img_place" />
                        <input type="submit" value="Done" id="button_upload" name="button_upload" class="btn btn-primary" data-dismiss="modal" onclick="location.reload();">
                        </form>
                        <?php //echo form_close();?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <!-- alert($("#img_place").val()) -->
            </div>
        </div>
    </div>
</div>

<div class="col-md-2 column">
<?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>

<div class="col-md-7">
    <div class="row form-group">
        <div class="col-md-12" style="padding-right: 5px"><!-- style doesnt work if moved to css file -->
            <ul class="list-inline list-unstyled member_profile_banner_images">
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(0)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[0] ?>" alt="">
                </li>
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(1)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[1] ?>" alt="">
                </li>
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(2)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[2] ?>" alt="">
                </li>
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(3)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[3] ?>" alt="">
                </li>
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(4)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[4] ?>" alt="">
                </li>
                <li class="col-md-2">
                    <img class="img-responsive" onclick="imgupload(5)" src="<?php echo base_url().USER_PHOTO_LIST_IMAGE_PATH_W100_H100.$photo_list[5] ?>" alt="">
                </li>
            </ul>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-9">
            <?php echo $basic_profile->about_me ?>
        </div>
        <div class="col-md-3">
            <?php if ($profile_type == PROFILE_MYSELF) { ?>
                <?php echo form_open("member_profile/update_basic_profile") ?>
                <button class="btn button-custom pull-right">Edit Profile</button>
                <?php echo form_close(); ?>
            <?php } elseif ($profile_type == PROFILE_FOLLOWER) { ?>
                <div class="col-md-8"><a href="<?php echo base_url() . 'messages/new_message/' . $user_id ?>"><button class="btn button-custom button-custom-profile-message">Message</button></a>
                </div>
                <div class="col-md-4">
                    <div class="dropdown friends-satus-dropdown pull-right" style="width: 35px">
                        <a id="friends_status" data-toggle="dropdown" href="#">
                            <img src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_unfollow_confirm('<?php echo $basic_profile->id; ?>')">Unfollow</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_block_confirm('<?php echo $basic_profile->id; ?>')">Block</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_report('<?php echo $basic_profile->id; ?>')">Report</a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } else if ($profile_type == PROFILE_PENDING_FOLLOWER) { ?>
                <button class="btn button-custom pull-right">Request Pending</button>
            <?php } else if ($profile_type == PROFILE_APPROVE_PENDING_FOLLOWER) { ?>
                <button id="button_accept_request" name="button_accept_request" class="btn button-custom pull-right">Accept Request</button>
            <?php } else if ($profile_type == PROFILE_BLOCKED_FOLLOWER) { ?>
                <button id="button_unblock" name="button_unblock" class="btn button-custom pull-right">Unblock</button>
            <?php } else { ?>
                <button class="btn button-custom pull-right" id="button_user_follow">Follow</button>
            <?php } ?>
        </div>
    </div>
    <?php $this->load->view("member/newsfeed/status_bar"); ?>
<?php $this->load->view("member/newsfeed/feed"); ?>
</div>
<?php $this->load->view("followers/modal_report");
      $this->load->view("followers/modal_unfollow_confirm");
      $this->load->view("followers/modal_block_confirm");