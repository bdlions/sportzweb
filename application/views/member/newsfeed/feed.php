<link rel="stylesheet" href="<?php echo base_url() ?>resources/bootstrap3/css/user_selection.css"/>
<script type="text/javascript">
    function remove_status(status_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "feed/delete_status",
            data: {
                status_id: status_id
            },
            success: function (data) {
                if (data == 1)
                {
                    $("#status_id_" + status_id).slideUp();
                }
                else
                {
                    //alert('Internal server error. Try again later.');
                    var message = "Internal server error. Try again later.";
                    print_common_message(message);
                }
            }
        });
    }
    function click_comment(status_id)
    {
        $("#text_input_comment_" + status_id).focus();
    }
    function click_like_feed_post(status_id, referenced_user_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/store_status_like",
            data: {
                status_id: status_id,
                referenced_user_id: referenced_user_id
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }

    function click_unlike_feed_post(status_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/remove_status_like",
            data: {
                status_id: status_id
            },
            success: function (data) {
                window.location.reload();
            }
        });
    }

    function show_liked_user_list(status_id)
    {

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/get_status_liked_user_list",
            data: {
                status_id: status_id

            },
            success: function (data) {
                $('#modal_liked_user_list').modal('show');
                $("#liked_user_list").html(tmpl("tmpl_liked_user_list", data));
            }
        });
    }

    function click_share_feed_post(status_id, referenced_user_id)
    {
        $('#modal_status_share').modal('show');
        $('#share_status_id').val(status_id);
        $('#referenced_user_id').val(referenced_user_id);
        /*$.ajax({
         dataType: 'json',
         type: "POST",
         url: '<?php echo base_url(); ?>' + "share/share_status",
         data: {
         status_id: status_id
         },
         success: function(data) {
         //window.location.reload();                    
         }
         });*/
    }
    $(function () {
        var newsfeeds = <?php echo json_encode(isset($newsfeeds) ? $newsfeeds : null); ?>;
        var next_start = <?php echo isset($newsfeeds) ? count($newsfeeds) : 0 ?>;
        $("#feeds").html($("#feeds").html()).append("<a href='<?php echo base_url(); ?>feed/get_statuses/<?php echo $status_list_id . "/" . $mapping_id . "/" . STATUS_LIMIT_PER_REQUEST ?>/" + next_start + "/<?php echo (isset($hashtag)) ? $hashtag : '' ?>'>next</a>");
        $('.scroll').jscroll({
            loadingHtml: '<div class="col-md-3 col-md-offset-6"><img src="<?php echo base_url() ?>resources/images/loading.gif" alt="Loading" /> Loading...</div>',
            padding: 20
        });
    });
    function store_status_feedback(evt, element, status_id, referenced_user_id)
    {
        if (evt.keyCode == 13)
        {
            var feedback = $(element).val();
            $this = $(element);
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "feed/ajax_post_feedback",
                data: {
                    status_id: status_id,
                    referenced_user_id: referenced_user_id,
                    feedback: feedback
                },
                success: function (data) {
                    $("#feedback_list_" + status_id).html($("#feedback_list_" + status_id).html() + tmpl("tmpl_add_feedback_info", data));
                    $this.val("");
                }
            });
        }
    }
</script>
<div id="feeds" class="scroll" data-ui="jscroll-default">
    <?php
    foreach ($newsfeeds as $newsfeed) {
        $this->data['newsfeed'] = $newsfeed;
        $this->load->view("member/newsfeed/status", $this->data);
    }
    ?>    
</div>
<?php $this->load->view("member/newsfeed/modal_liked_user_list"); ?>
<?php $this->load->view("member/newsfeed/modal_status_share"); ?>
<?php $this->load->view('member/album/modal_show_photo'); ?>
<script type="text/x-tmpl" id="tmpl_add_feedback_info">
{% var i=0, feedback_info = ((o instanceof Array) ? o[i++] : o); %}
{% while(feedback_info){ %}
<div class="row form-group">
    <div class="col-md-2 feed-profile-picture">
        <a href='<?php echo base_url() . "member_profile/show/{%= feedback_info.user_info.user_id %}" ?>'>
            <div class="profile-background-comment">
                <img alt="<?php echo '{%= feedback_info.user_info.first_name[0] %}' . '{%= feedback_info.user_info.last_name[0] %}' ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . '{%= feedback_info.user_info.photo %}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                <p style="visibility:hidden; font-size: 15px;"><?php echo '{%= feedback_info.user_info.first_name[0] %}' . '{%= feedback_info.user_info.last_name[0] %}' ?></p>
            </div>
        </a>
    </div>
    <div class="row col-md-10">
        <a href='<?php echo base_url() . "member_profile/show/{%= feedback_info.user_info.user_id %}" ?>' class="profile-name" ><?php echo '{%= feedback_info.user_info.first_name %}' . " " . '{%= feedback_info.user_info.last_name %}' ?></a> {%= feedback_info.feedback %}
    </div>
    <div class="row col-md-10" id="feedback_created_date">
        1 second ago
    </div>
</div>
{% feedback_info = ((o instanceof Array) ? o[i++] : null); %}
{% } %}
</script>
<?php
$this->load->view("applications/score_prediction/process_prediction");
$this->load->view("applications/score_prediction/prediction_confirmation_modal");