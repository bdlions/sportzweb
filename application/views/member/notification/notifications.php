<div class="row">
    <div class="col-md-10">
        <div class="pagelet">
            <div class="row">
                <div class="col-md-8">
                    <span style="font-weight: bold;">Your Notifications:</span>
                </div>
                <div class="col-md-4">
                    <div class="pull-right">

                    </div>
                </div>
            </div>
        </div>  
        <div class="pagelet">
            <?php foreach ($notification_list as $notification_info) { 
                ?>
                <div class="pagelet message_friends_box">
                    <div class="row">                        
                        <?php if (in_array($notification_info['type_id'], $notification_type_id_list)) { ?>
                            <div class="col-sm-3 feed-profile-picture">
                                <?php if (!empty($notification_info['reference_list'])) { ?>
                                    <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>'>
                                        <div>
                                            <img alt="<?php echo $notification_info['reference_list'][0]['first_name'][0] . $notification_info['reference_list'][0]['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $notification_info['reference_list'][0]['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                            <p style="visibility:hidden"><?php echo $notification_info['reference_list'][0]['first_name'][0] . $notification_info['reference_list'][0]['last_name'][0] ?></p>
                                        </div>
                                    </a>  
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="col-sm-9">
                            <?php
                            if ($notification_info['type_id'] == NOTIFICATION_WHILE_LIKE_ON_CREATED_POST || $notification_info['type_id'] == NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST || $notification_info['type_id'] == NOTIFICATION_WHILE_SHARES_CREATED_POST) {
                                $total_users = count($notification_info['reference_list']);
                                $counter = 1;
                                foreach ($notification_info['reference_list'] as $referenced_user_info) {
                                    if ($counter > 1) {
                                        if ($counter == 3 && $counter <= $total_users) {
                                            echo ' and ';
                                        } else if ($counter == $total_users) {
                                            echo ' and ';
                                        } else {
                                            echo ' , ';
                                        }
                                    }
                                    if ($counter == 3 && $total_users > 3) {
                                        ?>
                                        <a onclick="show_liked_user_list(<?php echo $reference_id; ?>)" href="#">
                                            <?php
                                            echo ($total_users - $counter + 1) . ' others';
                                            ?> 
                                        </a> 
                                        <?php
                                        break;
                                    }
                                    ?>   
                                    <a href='<?php echo base_url() . "member_profile/show/{$referenced_user_info['user_id']}" ?>' class="profile-name" ><?php echo $referenced_user_info['first_name'] . " " . $referenced_user_info['last_name']; ?></a>                            
                                    <?php
                                    $counter++;
                                }
                                $reference_id = $notification_info['reference_id'];
                                $created_on = $notification_info['created_on'];
                                if ($notification_info['type_id'] == NOTIFICATION_WHILE_LIKE_ON_CREATED_POST) {
                                    if ($total_users == 1) {
                                        echo ' likes';
                                    } else if ($total_users > 1) {
                                        echo ' like';
                                    }
                                    ?>
                                    <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'> your post</a>    
                                    <?php echo $created_on; ?>
                                    <?php
                                } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST) {
                                    if ($total_users >= 1) {
                                        echo ' commented on';
                                    } else if ($total_users > 3) {
                                        echo 'also commented on';
                                    }
                                    ?>
                                    <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'> your post</a> 
                                    <?php echo $created_on; ?> 
                                    <?php
                                } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_SHARES_CREATED_POST) {
                                    if ($total_users >= 1) {
                                        echo ' shared';
                                    } else if ($total_users > 3) {
                                        echo 'also shared';
                                    }
                                    ?>
                                    <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'>your post</a> 
                                    <?php
                                    echo $created_on;
                                }
                            }
                            if ($notification_info['type_id'] == NOTIFICATION_WHILE_PREDICT_MATCH) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list']['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>                            
                                your
                                <a href='<?php echo base_url() . "applications/score_prediction/index/{$notification_info['reference_id']}" ?>'> prediction </a> 
                                is correct
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_assessment/{$notification_info['reference_id']}" ?>'>has created an assessment for you</a>
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_program/{$notification_info['reference_id']}" ?>'>has created a program for you</a>
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM_REVIEW) {
                                ?>
                                A review of
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info["reference_list"][0]["first_name"] . " " . $notification_info["reference_list"][0]["last_name"]."'s"; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_program/{$notification_info['reference_id']}" ?>'> program </a>
                                is due today
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_mission/{$notification_info['reference_id']}" ?>'>has created a mission for you</a>
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_exercise/{$notification_info['reference_id']}" ?>'>has created an exercise for you</a>
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_nutrition/{$notification_info['reference_id']}" ?>'>has created a nutrition plan for you</a>
                            <?php }if ($notification_info['type_id'] == NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION) {
                                ?>
                                <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_list'][0]['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_list'][0]['first_name'] . " " . $notification_info['reference_list'][0]['last_name']; ?></a>
                                <a href='<?php echo base_url() . "applications/gympro/show_session/{$notification_info['reference_id']}" ?>'>has created a session for you</a>
                            <?php }
                            ?>
                        </div>
            
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>