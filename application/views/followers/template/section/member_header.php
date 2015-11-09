<script type="text/javascript">
    $(function() {
        $("#search_followers_box").typeahead([{
                name: "show_followers",
                prefetch: {
                    url: '<?php echo base_url() ?>search/get_followers/',
                    ttl: 0
                },
                template: [
                    '<div class="row">' +
                            '<div class="col-md-3">' +
                            '<div>' +
                            '<img alt="{{signature}}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH ?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background profile_background_search_bar\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>' +
                            '<div style="visibility:hidden;height:0px">{{signature}}</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-9">' +
                            '<div class="row col-md-12 profile-name">' +
                            '{{first_name}} {{last_name}}' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                ].join(''),
                engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
            window.location = "<?php echo base_url() ?>member_profile/show/" + datum.user_id;
        });
    });

    function open_modal_unfollow_confirm(follower_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_unfollow_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info));
                $('#span_unfollow_confirm_message').text('Unfollow ' + data.user_info.first_name + ' ' + data.user_info.last_name + '?');
                $('#follower_id_confirm_unfollow').val(follower_id);
                $('#modal_unfollow_confirm').modal('show');
            }
        });
        //$('#follower_id_confirm_unfollow').val(follower_id);
        //$('#modal_unfollow_confirm').modal('show');
    }

    function open_modal_block_confirm(follower_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_block_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info));
                $('#span_block_confirm_message').text('Block ' + data.user_info.first_name + ' ' + data.user_info.last_name + '?');
                $('#follower_id_confirm_block').val(follower_id);
                $('#modal_block_confirm').modal('show');
            }
        });

        //$('#follower_id_confirm_block').val(follower_id);
        //$('#modal_block_confirm').modal('show');
    }

    function open_modal_unblock_confirm(follower_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_unblock_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info));
                $('#span_unblock_confirm_message').text('Unblock ' + data.user_info.first_name + ' ' + data.user_info.last_name + '?');
                $('#follower_id_confirm_unblock').val(follower_id);
                $('#modal_unblock_confirm').modal('show');
            }
        });
        //$('#follower_id_confirm_unblock').val(follower_id);
        //$('#modal_unblock_confirm').modal('show');
    }

    function open_modal_report(follower_id) {
        $('#follower_id').val(follower_id);
        $('#<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID ?>').attr('checked', false);
        $('#<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID ?>').attr('checked', false);
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_follower_info").html(tmpl("tmpl_user_info", data.user_info));
                $('#span_shared_content').text('Report content shared by ' + data.user_info.first_name + ' ' + data.user_info.last_name);
                $('#modal_report_content').modal('show');
            }
        });

    }
</script>
<div class="row" style="padding-bottom: 30px;">
    <div class="col-md-4 form-group">
        <div class=" input-group search-box-followers">
            <input id="search_followers_box" class="form-control typeahead" type="text" placeholder="Search for followers" />
            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
        </div>
    </div>       
    <div class="col-md-8"> 
        <ul class="list-inline follower_list_inline_custom">
            <li class="form-group">
                <a href="<?php echo base_url() . 'followers/invite' ?>"><button style="width:100%" class="btn button-custom btn-sm">Invite</button></a>                    
            </li>
            <li class="form-group">
                <a href="<?php echo base_url() . 'followers/show/' . $user_id ?>"><button style="width:100%" class="btn button-custom btn-sm">My Followers</button></a>
            </li>
            <li class="form-group">
                <a href="<?php echo base_url() . 'followers/blocked_followers/' . $user_id ?>"><button style="width:100%" class="btn button-custom btn-sm">Blocked Members</button></a>                    
            </li>
             <li class="form-group">
                <?php if ($follow_permission->value == FOLLOWER_ACCEPTANCE_TYPE_MANUAL) { ?>
                    <a href="<?php echo base_url().'followers/pending_followers/'. $user_id    ?>"><button style="width:100%" class="btn button-custom btn-sm" id="button_pending_request">Pending Requests</button></a>
                <?php } ?>
            </li>
        </ul>
    </div>
</div>
<?php
$this->load->view("followers/modal_report");
$this->load->view("followers/modal_unfollow_confirm");
$this->load->view("followers/modal_block_confirm");
$this->load->view("followers/modal_unblock_confirm");
