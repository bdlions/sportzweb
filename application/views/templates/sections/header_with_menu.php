<?php $this->load->view("custom_typeahead/custom_typeahead"); ?>
<script type="text/javascript">

    $(function () {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "notifications/get_all_notification_list",
            success: function (data) {
                if (data.total_unread_followers > 0) {
                    $("#follower_counter_dive").show();
                    $("#follower_counter_dive").val(data.total_unread_followers);
                    $("#follower_counter_dive").html(data.total_unread_followers);
                }

                if (data.total_unread_notifications > 0) {
                    $("#notification_counter_div").show();
                    $("#notification_counter_div").val(data.total_unread_notifications);
                    $("#notification_counter_div").html(data.total_unread_notifications);
                }

                $("#notification_list").html(tmpl("tmpl_notification", data.notification_list));
                $("#follower_list").html(tmpl("tmpl_followers", data.notification_list));
            }
        });



        $("#mm_notification").on("click", function () {
            $('#mm_notification_box').show();
            var notification_type_id_list = [
                "<?php echo NOTIFICATION_WHILE_LIKE_ON_CREATED_POST; ?>",
                "<?php echo NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST; ?>",
                "<?php echo NOTIFICATION_WHILE_SHARES_CREATED_POST; ?>",
                "<?php echo NOTIFICATION_WHILE_PREDICT_MATCH; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT; ?>",
                "<?php echo NOTIFICATION_TYPE_ID_GYMPRO_ASSESSMENT_REASSESS; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM_REVIEW; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION; ?>",
                "<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION; ?>"
            ];
            update_notifications_status(notification_type_id_list, 1);
        });
        $("#mm_friend_request").on("click", function () {
            $('#mm_friend_request_box').show();
            var notification_type_id_list = [
                "<?php echo NOTIFICATION_WHILE_START_FOLLOWING; ?>"
            ];
            update_notifications_status(notification_type_id_list, 2);
        });
        $("#mm_messages").on('click', function () {
            window.location = '<?php echo base_url(); ?>messages';
//            $('#mm_message_box').show();
        });
    });

    function update_notifications_status(notification_type_id_list, notification_category) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "notifications/update_notifications_status",
            data: {
                notification_type_id_list: notification_type_id_list
            },
            success: function (data) {
                if (data === 1 && notification_category === 1) {
                    $('#notification_counter_div').hide();
                } else if (data === 1 && notification_category === 2) {
                    $('#follower_counter_dive').hide();
                }
            }
        });
    }

    $(document).mouseup(function (e) {
        var fr_container = $("#mm_friend_request_box");
        var container = $("#mm_notification_box");
        var msg_container = $("#mm_message_box");
        var typeahead_container = $("#page_late_id");

        if (!fr_container.is(e.target) && fr_container.has(e.target).length === 0) {
            fr_container.hide();
        }
        if (!msg_container.is(e.target) && msg_container.has(e.target).length === 0) {
            msg_container.hide();
        }
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
        if (!typeahead_container.is(e.target) && typeahead_container.has(e.target).length === 0) {
            typeahead_container.hide();
        }
    });

    function open_modal_accept_confirm(follower_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function (data) {
                $("#div_accept_confirm_follower_info").html(tmpl("tmpl_user_info", data.user_info));
                $('#span_accept_confirm_message').text('Accept ' + data.user_info.first_name + ' ' + data.user_info.last_name + '?');
                $('#follower_id_confirm_accept').val(follower_id);
                $('#modal_accept_confirm').modal('show');
            }
        });
    }


</script>
<script type="text/x-tmpl" id="tmpl_notification">
{% var i=0, notification_info = ((o instanceof Array) ? o[i++] : o);
while(notification_info){ %}

{% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_LIKE_ON_CREATED_POST; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST; ?>'|| notification_info.type_id == '<?php echo NOTIFICATION_WHILE_SHARES_CREATED_POST; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_PREDICT_MATCH; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_TYPE_ID_GYMPRO_ASSESSMENT_REASSESS; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM_REVIEW; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION; ?>'){ %}

<div class="pagelet message_friends_box">
    <div class="row">
        <div class="col-md-3 feed-profile-picture">
            {% if(notification_info.reference_list != null){ %}
            <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>'>
                <div>
                    <img alt="{%= notification_info.reference_list[0].first_name[0] %}{%= notification_info.reference_list[0].last_name[0] %}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . '{%= notification_info.reference_list[0].photo%}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                    <p style="visibility:hidden">{%= notification_info.reference_list[0].first_name[0] %}{%= notification_info.reference_list[0].last_name[0] %}</p>
                </div>
            </a>
            {%}%}
        </div>
        <div class="col-md-9">
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_LIKE_ON_CREATED_POST; ?>' || notification_info.type_id == '<?php echo NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST; ?>'|| notification_info.type_id == '<?php echo NOTIFICATION_WHILE_SHARES_CREATED_POST; ?>'){ %}
                {% var counter = 1;
                var total_users = notification_info.reference_list.length; %}

                {% for(var j = 0;j <total_users;j++){

                if(counter > 1){ 
                if(counter == 3 && counter <= total_users){ %}
                <?php echo " and "; ?>
                {% }else if(counter == total_users){  %}
                <?php echo " and "; ?>
                {% }else{  %}
                <?php echo " , "; ?>
                {% }  }  %}
                <a href='<?php echo base_url() . "member_profile/show/" ?>{%= notification_info.reference_list[j].user_id %}' class="profile-name">{%= notification_info.reference_list[j].first_name %} {%= notification_info.reference_list[j].last_name %}</a>
                {% counter++;
                } %}

                {% var created_on =notification_info.created_on ; 
                var reference_id =notification_info.reference_id ;
                if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_LIKE_ON_CREATED_POST; ?>') { 
                if(total_users == 1){ %}
                likes
                {% }
                if(total_users > 1){ %}
                like
                {% }
                }%}
                {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST; ?>') { 
                if(total_users >= 1){ %}
                commented on
                {% }
                if(total_users > 3){ %}
                also commented on
                {% }
                }%}
                {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_SHARES_CREATED_POST; ?>') { 
                if(total_users >= 1){ %}
                shared
                {% }
                if(total_users > 3){ %}
                also shared
                {% }
                }%}
                <a href='<?php echo base_url() . "member_profile/view_shared_status/{%=reference_id%}" ?>'> your post </a>
                <div> {%= created_on%} </div> 
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_PREDICT_MATCH; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                your 
                <a href='<?php echo base_url() . "applications/score_prediction/index/{%=notification_info.reference_id %}" ?>'>prediction</a>
                is correct
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_assessment/{%=notification_info.reference_id %}" ?>'>has created an assessment for you</a>
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_TYPE_ID_GYMPRO_ASSESSMENT_REASSESS; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}'s</a>
                <a href='<?php echo base_url() . "applications/gympro/show_assessment/{%=notification_info.reference_id %}" ?>'> assessment </a>
                is due today
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_program/{%=notification_info.reference_id %}" ?>'>has created a program for you</a>
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM_REVIEW; ?>'){ %}
                A review of 
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}'s</a>
                <a href='<?php echo base_url() . "applications/gympro/show_program/{%=notification_info.reference_id %}" ?>'> program </a>
                is due today
                
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_mission/{%=notification_info.reference_id %}" ?>'>has created a mission for you</a>
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_exercise/{%=notification_info.reference_id %}" ?>'>has created an exercise for you</a>
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_nutrition/{%=notification_info.reference_id %}" ?>'>has created a nutrition plan for you</a>
            {%}%}
            {% if(notification_info.type_id == '<?php echo NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION; ?>'){ %}
                <a href='<?php echo base_url() . "member_profile/show/{%=notification_info.reference_list[0].user_id %}" ?>' class="profile-name">{%= notification_info.reference_list[0].first_name %} {%= notification_info.reference_list[0].last_name %}</a>
                <a href='<?php echo base_url() . "applications/gympro/show_session/{%=notification_info.reference_id %}" ?>'>has created a session for you</a>
            {%}%}
        </div>
    </div>    
</div>
{% } %}
{% notification_info = ((o instanceof Array) ? o[i++] : null); %}
{% } %}


</script>
<script type="text/x-tmpl" id="tmpl_followers">
    {% var i=0, notification_list = ((o instanceof Array) ? o[i++] : o);%}
    {%while(notification_list){ %}
        {% if(notification_list.type_id == '<?php echo NOTIFICATION_WHILE_START_FOLLOWING; ?>'){ %}
            <div class="pagelet">
                <div class="row">
                    <div class="col-md-3 feed-profile-picture">
                        <a href='<?php echo base_url() . "member_profile/show/{%= notification_list.reference_info.user_id %}" ?>'>
                            <div>
                                <img alt="{%= notification_list.reference_info.first_name[0] %}{%= notification_list.reference_info.last_name[0] %}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . '{%= notification_list.reference_info.photo%}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                <p style="visibility:hidden">{%= notification_list.reference_info.first_name[0] %}{%= notification_list.reference_info.last_name[0] %}</p>
                            </div>
                        </a>   
                    </div>
                    <div class="col-md-5">
                        <a href='<?php echo base_url() . "member_profile/show/{%= notification_list.reference_info.user_id %}" ?>'>
                            <span class="profile-name" >{%= notification_list.reference_info.first_name %} {%= notification_list.reference_info.last_name %} </span>
                        </a>
                    </div>  
                    {% if(notification_list.following_acceptance_type != null && notification_list.following_acceptance_type == '<?php echo FOLLOWER_ACCEPTANCE_TYPE_ID_CONFIRMATION;?>'){ %}
                        <div class="col-md-3">
                            <div class="pull-right">
                                <button type="submit" onclick="open_modal_accept_confirm('<?php echo '{%= notification_list.reference_info.user_id %}'; ?>')" class="btn btn-xs follower_button_style">Accept</button>
                            </div>
                        </div>
                    {% } %}
                </div>
            </div>
        {% } %}
        {% notification_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>



<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">

        </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="container">
            <div class="row">
                <div class="col-md-4 logo-text">
                    <a href="<?php echo base_url(); ?>" ><img class="logo" src="<?php echo base_url() . DEFAULT_LOGO ?>" /><?php echo WEBSITE_TITLE; ?></a>
                </div>

                <div class="col-md-8">
                    <div class="header-menu-row">
                        <div class="col-md-offset-1 col-md-6" >
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input id="typeahead" class="form-control" type="text" placeholder="Search for people and interests" />
                                    <?php $this->load->view("custom_typeahead/typeahead_tmpl"); ?>
                            </div>
                        </div>
                        <div class="col-md-offset-1 col-md-4 right-menu">
                            <div style="margin-top: -4px;">

                                <div id="mm_friend_request" style="position: relative">
                                    <div class="notification_counter" id="follower_counter_dive" style="display: none">
                                    </div>
                                    <a href="javascript:void(0)"></a>                
                                    <div id="mm_friend_request_box">
                                        <?php $this->load->view("followers/notification_followers"); ?>
                                    </div>
                                </div>
                                <div id="mm_messages" style="position: relative">
                                    <a href="javascript:void(0)"></a>

                                    <div id="mm_message_box">
                                        <?php $this->load->view("member/messages/notification_message"); ?>
                                    </div>
                                </div>

                                <div id="mm_notification" style="position: relative">

                                    <div class="notification_counter" id="notification_counter_div" style="display: none">
                                    </div>
                                    <a href="javascript:void(0)"></a>
                                    <div id="mm_notification_box">
                                        <?php $this->load->view("member/notification/notification_notifications"); ?>
                                    </div>
                                </div>
                                <div id="mm_setting" style="position: relative;">
                                    <a href="#" data-toggle="dropdown" id="dropdownMenuRight">
                                        <img src="<?php echo base_url(); ?>resources/images/menu.png">
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuRight">
                                        <?php if ($business_profile_info == FALSE) { ?>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Create my business profile</a>
                                            </li>
                                        <?php } else { ?>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>business_profile/show"><?php echo $business_profile_info->business_name ?></a>
                                            </li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="#">Advertise</a>
                                            </li>
                                        <?php } ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings/">Account settings</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings.html?menu=privacy&section=tag_photo">Privacy settings</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings/applications">Application settings</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>member_general/contact_us">Support</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>auth/logout">Log out</a>
                                        </li>
                                    </ul>
                                </div>

                                <!--                                <a href="#">
                                                                    <img src="<?php //echo base_url(); ?>resources/images/friends.png">
                                                                </a>
                                                                <a href="#">
                                                                    <img src="<?php //echo base_url(); ?>resources/images/bell.png">
                                                                </a>
                                                                <a href="<?php //echo base_url() . 'messages' ?>">
                                                                    <img src="<?php //echo base_url(); ?>resources/images/inbox.png">
                                                                </a>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (isset($application_id) && $application_id == APPLICATION_GYMPRO_ID): ?>
        <?php $this->load->view("applications/gympro/template/sections/top_banner"); ?>
    <?php endif; ?>
</nav>

<?php
$this->load->view("followers/modal_accept_confirm");
