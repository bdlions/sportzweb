<script type="text/javascript">
    $(function() {

        $("#chat_friends").typeahead([{
                name: "chat_friends",
                prefetch: {
                    url: '<?php echo base_url() ?>search/get_followers/',
                    ttl: 0
                },
                template: [
                    '<div class="row">' +
                            '<div class="col-md-3">' +
                            '<div>' +
                            '<img alt="{{signature}}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH ?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>' +
                            '<div style="visibility:hidden;height:0px">{{signature}}</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-9">{{first_name}} {{last_name}}</div>' +
                            '</div>'
                ].join(''),
                engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
            window.location = "<?php echo base_url() ?>messages/user/" + datum.user_id;
        });



//        $("#search_inbox").typeahead([
//            {
//                name: "inbox_user",
//                //local:[{"username":"Alamgir Kabir","first_name":"Alamgir","last_name":"Kabir","value":"alamgir", "user_id":"2"},{"username":"Nazmul Hasan","first_name":"Nazmul","last_name":"Hasan","value":"nazmul hasan", "user_id":"3"}],
//                remote:'<?php echo base_url() ?>search/get_users?query=%QUERY',
//                template: [
//                    '<div class="col-md-3"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c5.5.65.65/s56x56/65686_10201374763675922_1110161127_t.jpg"/></div>',
//                    '<div class="col-md-9 content_text">{{first_name}} {{last_name}}</div>'
//                ].join(''),
//                engine: Hogan
//            }
//            ]).on('typeahead:selected', function(obj, datum) {
//            window.location = "<?php echo base_url() ?>member_profile/show/" + datum.user_id;
//        });

        $("#buttonPost").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>messages/send_message/',
                data: $("#postMessage").serialize(),
                dataType: 'json',
                success: function(data) {//console.log(data);
                    if (data == true) {
                        window.location.reload();
                    }
                    else {
//                          alert("error for following users.");
                        var message = "error for following users.";
                        print_common_message(message);
                    }
                }
            });
            return false;
        });

        $("#new_message").on("click", function() {
            window.location = "<?php echo base_url() ?>messages/new_message";
        });
    });
</script>
<script type="text/javascript">
    (function($) {
        $(window).load(function() {
            $("#msg_box .msg").mCustomScrollbar({
                setHeight: 300,
                theme: "dark-3"
            });
        });
    })(jQuery);
</script>
<div class="col-md-2">
    <div class="heading_medium_thin form-group"><a href="<?php echo base_url() ?>messages">Inbox</a></div>
    <?php foreach ($followers as $follower) { ?>
        <div class="row form-group">
            <div class="col-md-12">
                <a href="<?php echo base_url() ?>messages/user/<?php echo $follower->user_id ?>">
                    <div class="profile-background">
                        <img alt="<?php echo $follower->first_name[0] . $follower->last_name[0] ?>" src="<?php echo base_url() ?>resources/uploads/profile_picture/100x100/<?php echo $follower->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible'; " /> 
                        <div style="visibility:hidden"><?php echo $follower->first_name[0] . $follower->last_name[0] ?></div>
                    </div>
                    <div class="small_text_pale"><?php echo $follower->first_name . " " . $follower->last_name ?></div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
<div class="col-md-7" style="border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC">
    <div class="row">
        <div class="col-md-12">
            <div class="row" style="padding-bottom: 20px; padding-top: 10px;">
                <div class="col-md-5 form-group">
                    <div class=" input-group search-box-followers">
                        <!--<input id="search_inbox" class="form-control typeahead" type="text" placeholder="Search inbox" />-->
                        <input id="chat_friends" class="form-control typeahead search-user" type="text" placeholder="To: Name or Group" />
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    </div>
                </div>
                <div class="col-md-7">
                    <button class="btn button-custom pull-right" id="new_message">New Message</button>
                </div>
            </div>
            <div id="msg_box">
                <div class="msg">
                    <?php foreach ($messages as $message) { ?>
                        <div class="row" style="padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #CCCCCC">
                            <div class="row">
                                <?php
                                if ($message->from == $me->user_id) {
                                    $user = $me;
                                } else {
                                    foreach ($followers as $follower) {
                                        if ($follower->user_id == $message->from) {
                                            $user = $follower;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <div class="col-md-2" style="margin-left: 20px;">
                                    <div class="profile-background"><img alt="<?php echo $user->first_name[0] . $user->last_name[0] ?>" src="<?php echo base_url() ?>resources/uploads/profile_picture/100x100/<?php echo $user->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible'; " /> 
                                        <div style="visibility:hidden;"><?php echo $user->first_name[0] . $user->last_name[0] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-9 content_text">
                                    <?php echo $user->first_name . " " . $user->last_name . ": " . $message->message ?>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="pull-right small_text_pale"><?php echo $message->received_date; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
                <div class="col-md-12">
                    <?php
                    if (isset($to)) {
                        echo form_open("", "id='postMessage'")
                        ?>
                        <!--                <div class="col-md-2"> </div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <textarea rows="3" name="message" class="form-control custom-textarea"></textarea>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <input type="hidden" value="<?php echo $to ?>" name="to"/>
                                <button class="btn button-custom pull-right" id="buttonPost">Post</button>
                            </div>
                        </div>

                        <?php
                        echo form_close();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="col-md-12">
        <h4>Participants</h4>
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" placeholder="Add name or email..."/>
            </div>
        </div>
        <?php foreach ($followers as $follower) { ?>
            <div class="row">
                <div class="col-md-12">
                    <img src="<?php echo base_url() . 'resources/images/' . ($follower->online_status == TRUE ? 'online.png' : 'offline.png') ?>" />
                    <?php echo $follower->first_name . " " . $follower->last_name ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>