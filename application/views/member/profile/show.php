<script type="text/javascript">
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
                        alert("error for following users.");
                    }
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
<div class="col-md-7 column">
    <div class="row" style="padding-bottom: 10px;">
        <div class="col-md-12" style="padding-right: 0px;">
            <ul class="list-inline list-unstyled">
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(0)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[0] ?>" alt="">
                </li>
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(1)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[1] ?>" alt="">
                </li>
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(2)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[2] ?>" alt="">
                </li>
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(3)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[3] ?>" alt="">
                </li>
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(4)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[4] ?>" alt="">
                </li>
                <li class="col-md-2" style="padding-left: 0px;">
                    <img width="100px" height="100px" onclick="imgupload(5)" src="<?php echo base_url(); ?>resources/uploads/user_photo/<?php echo $photo_list[5] ?>" alt="">
                </li>
            </ul>
        </div>
    </div>
    <div class="row" style="padding-bottom: 10px;">
        <div class="col-md-9">
            <?php echo $basic_profile->about_me ?>
        </div>
        <div class="col-md-3">
            <?php if ($is_myself) { ?>
                <?php echo form_open("member_profile/update_basic_profile") ?>
                <button class="btn button-custom pull-right">Edit Profile</button>
                <?php echo form_close(); ?>
                <?php } elseif ($is_follower) { ?>


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
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() . 'followers/remove_follower/' . $user_id ?>">Unfollow</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Block</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Report</a>
                            </li>
                        </ul>
                    </div>
                </div>



            <?php } else if ($is_pending) { ?>
                <button class="btn button-custom pull-right">Request Pending</button>
            <?php } else { ?>
                <button class="btn button-custom pull-right" id="button_user_follow">Follow</button>
            <?php } ?>
        </div>
    </div>
    <?php $this->load->view("member/newsfeed/status_bar"); ?>
<?php $this->load->view("member/newsfeed/feed"); ?>
</div>