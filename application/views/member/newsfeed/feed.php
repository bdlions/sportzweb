<link rel="stylesheet" href="<?php echo base_url()?>resources/bootstrap3/css/user_selection.css"/>
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
            success: function(data) {
                if(data == 1)
                 {
                     $("#status_id_"+status_id).slideUp();
                 } 
                 else
                 {
                     alert('Internal server error. Try again later.');
                 }
            }
        });
    }
    function click_comment(status_id)
    {
        $("#text_input_comment_"+status_id).focus();
    }
    function click_like_feed_post(status_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/store_status_like",
            data: {
                status_id: status_id
            },
            success: function(data) {
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
            success: function(data) {
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
            success: function(data) {
                $('#modal_liked_user_list').modal('show');     
                $("#liked_user_list").html(tmpl("tmpl_liked_user_list",  data));                      
            }
        });
    }
    
    function click_share_feed_post(status_id)
    {
        $('#modal_status_share').modal('show');
        $('#share_status_id').val(status_id);
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
    $(function() {
        var newsfeeds = <?php echo json_encode(isset($newsfeeds) ? $newsfeeds: null); ?>;
        var next_start = <?php echo isset($newsfeeds) ?  count($newsfeeds):  0 ?>;
        $("#feeds").html($("#feeds").html()).append("<a href='<?php echo base_url();?>feed/get_statuses/<?php echo $status_list_id."/".$mapping_id."/".STATUS_LIMIT_PER_REQUEST?>/"+ next_start +"/<?php echo (isset($hashtag)) ? $hashtag : ''?>'>next</a>");
        $('.scroll').jscroll({
            loadingHtml: '<div class="col-md-3 col-md-offset-6"><img src="<?php echo base_url()?>resources/images/loading.gif" alt="Loading" /> Loading...</div>',
            padding: 20
        });          
    });
    function store_status_feedback(evt, element, status_id)
    {
        if(evt.keyCode == 13)
        {
            var feedback = $(element).val();
            $this = $(element);
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "feed/ajax_post_feedback",
                data: {
                    status_id: status_id,
                    feedback: feedback
                },
                success: function(data) {
                    $("#feedback_list_"+status_id).html($("#feedback_list_"+status_id).html()+tmpl("tmpl_add_feedback_info",  data));
                    $this.val("");
                }
            });
        }
    }
</script>
<div id="feeds" class="scroll" data-ui="jscroll-default">
    
    
    
    
    
    
    
    
    <!--PHOTOGRAPHY POST-->
    <div class="form-group">
        <div class="row form-group">
            <a href="<?php echo base_url().PHOTOGRAPHY_HOME_PAGE_PATH ?>">
                <div class="col-sm-2">
                    <img class="img-responsive" style="width: 100%" 
                         src="<?php echo base_url().APPLICATION_ICON_PATH.PHOTOGRAPHY_ICON ?>">
                </div>
                <div class="col-sm-10">
                    <div class="form-group" style="color: black">
                        <h3>
                            <?php 
                            foreach ($applications_info as $application_data) {
                                if( $application_data['id'] == APPLICATION_PHOTOGRAPHY_ID ){
                                    echo $application_data['title'];
                                }
                            } 
                           ?>
                        </h3>
                    </div>
                    <div class="form-group small_text_pale">
                        Shemai - The Blue Car
                    </div>
                </div>
            </a>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <img class="img-responsive" style="width: 100%" src="<?php echo base_url().APPLICATION_ICON_PATH.SERVICE_DIRECTORY_ICON ?>">
            </div>
        </div>
    </div>
    <!--PHOTOGRAPHY POST end-->
    
    
    
    <!--GYMPRO POST-->
    <div class="row">
        <div class="col-sm-12">
            <a href="<?php echo base_url().GYMPRO_HOME_PAGE_PATH?>">
                
            <img class="img-responsive" style="width: 100%" 
                 src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_ADDVERT_PICTURE_NAME ?>">
            </a>
        </div>
    </div>
    <!--GYMPRO POST-->
    
    
    
    
    
    
    
    
    
    <!--SERVICE DIRECTORY POST-->
<style>
    .sd_home_input{
        border: 3px solid #888888;
        padding: 10px;
        width: 100%;
        font-size: 16px;
        line-height: 16px;
    }
    #submit_service_directory{
        border-radius: 0; 
        background-color: #FFC90E;
        color: red;
        font-size: 16px;
        padding: 5px;
        width: 100px;
    }
</style>    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
            <img class="img-responsive" src="<?php echo base_url().SERVICE_HOME_LOGO_PATH?>">
        </div>
        <?php echo form_open("applications/service_directory/service_directory_map", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
            <div class="form-group">
                <input placeholder="Enter your location here" class="sd_home_input" name="towncode">
            </div>
            <div class="form-group">
                <input class="btn pull-right" name="submit_service_directory" type="submit" value="Find" id="submit_service_directory">
            </div>
        <?php echo form_close();?>
        </div>
    </div>
    <!--SERVICE DIRECTORY POST END-->
    
    
    
    
    
    
    
    
    
    
    
    <?php foreach ($newsfeeds as $newsfeed) { 
        $this->data['newsfeed'] = $newsfeed;  
        $this->load->view("member/newsfeed/status", $this->data); 
    } ?>
</div>
<?php $this->load->view("member/newsfeed/modal_liked_user_list"); ?>
<?php $this->load->view("member/newsfeed/modal_status_share"); ?>
<?php $this->load->view('member/album/modal_show_photo');?>
<script type="text/x-tmpl" id="tmpl_add_feedback_info">
    {% var i=0, feedback_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(feedback_info){ %}
        <div class="row form-group">
            <div class="col-md-2 feed-profile-picture">
                <a href='<?php echo base_url(). "member_profile/show/{%= feedback_info.user_info.user_id %}"?>'>
                    <div class="profile-background-comment">
                        <img alt="<?php echo '{%= feedback_info.user_info.first_name[0] %}' . '{%= feedback_info.user_info.last_name[0] %}'?>" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.'{%= feedback_info.user_info.photo %}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                        <p style="visibility:hidden"><?php echo '{%= feedback_info.user_info.first_name[0] %}'.'{%= feedback_info.user_info.last_name[0] %}' ?></p>
                    </div>
                </a>
            </div>
            <div class="row col-md-10">
                <a href='<?php echo base_url(). "member_profile/show/{%= feedback_info.user_info.user_id %}"?>' class="profile-name" ><?php echo '{%= feedback_info.user_info.first_name %}' . " ". '{%= feedback_info.user_info.last_name %}'?></a> {%= feedback_info.feedback %}
            </div>
            <div class="row col-md-10" id="feedback_created_date">
                1 second ago
            </div>
        </div>
    {% feedback_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>