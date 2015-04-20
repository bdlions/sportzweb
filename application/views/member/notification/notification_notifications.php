<div class="pagelet">
    <div class="row">
        <div class="col-xs-6">
            <span style="font-size: 12px; font-weight: bold;">Notifications</span>
        </div>
        <div class="col-xs-6">
            <div style="text-align: right">
                <a style="font-size: 11px;" href="#">Mark as Read</a> . 
                <a style="font-size: 11px;" href="#">Settings</a>
            </div>
        </div>
    </div>
</div>
<div class="scroll_box_style">
    <?php foreach ($notification_list as $notification_info) { ?>
        <div class="pagelet message_friends_box">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $reference_id = $notification_info['reference_id'];
                    $created_on = $notification_info['created_on'];
                    $total_users = count($notification_info['reference_list']);
                    $counter = 1;
                    if ($notification_info['type_id'] == NOTIFICATION_WHILE_LIKE_ON_CREATED_POST) {
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
                           if ($counter == 1) { ?>
                                <img src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $referenced_user_info['photo'] ?>">   
                            <?php }
                            ?>   
                            <a href='<?php echo base_url() . "member_profile/show/{$referenced_user_info['user_id']}" ?>' class="profile-name" ><?php echo $referenced_user_info['first_name'] . " " . $referenced_user_info['last_name']; ?></a>                            
                            <?php
                            $counter++;
                        }
                        if ($total_users == 1) {
                            echo ' likes ';
                        } else if ($total_users > 1) {
                            echo ' like ';
                        }
                        ?>
                        <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'>Your post</a>                            
                        <?php
                        echo $created_on;
                    } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST) {
                        foreach ($notification_info['reference_list'] as $referenced_com_user_info) {
                            if ($counter > 1) {
                                if ($counter == 3 && $counter <= $total_users) {
                                    echo ' and ';
                                } else if ($counter == $total_users) {
                                    echo ' and ';
                                } else {
                                    echo ' , ';
                                }
                            }
                          if ($counter == 1) { ?>
                                <img src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $referenced_com_user_info['photo'] ?>">   
                            <?php }
                            ?>
                            <a href='<?php echo base_url() . "member_profile/show/{$referenced_com_user_info['user_id']}" ?>' class="profile-name" ><?php echo $referenced_com_user_info['first_name'] . " " . $referenced_com_user_info['last_name']; ?></a>                            
                            <?php
                            $counter++;
                        }
                        if ($total_users >= 1) {
                            echo ' Commented on.';
                        } else if ($total_users > 3) {
                            echo 'also commented on';
                        }
                        ?>
                        <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'>Your post</a>  
                        <?php
                        echo $created_on;
                    } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_SHARES_CREATED_POST) {
                        foreach ($notification_info['reference_list'] as $referenced_share_user_info) {
                            if ($counter > 1) {
                                if ($counter == 3 && $counter <= $total_users) {
                                    echo ' and ';
                                } else if ($counter == $total_users) {
                                    echo ' and ';
                                } else {
                                    echo ' , ';
                                }
                            }
                           if ($counter == 1) { ?>
                                <img src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $referenced_share_user_info['photo'] ?>">   
                            <?php }
                            ?>
                            <a href='<?php echo base_url() . "member_profile/show/{$referenced_share_user_info['user_id']}" ?>' class="profile-name" ><?php echo $referenced_share_user_info['first_name'] . " " . $referenced_share_user_info['last_name']; ?></a>                            
                            <?php
                            $counter++;
                        }
                        if ($total_users >= 1) {
                            echo ' shared';
                        } else if ($total_users > 3) {
                            echo 'also shared';
                        }
                        ?>
                        <a href='<?php echo base_url() . "member_profile/view_shared_status/{$reference_id}" ?>'>Your post</a>  
                        <?php
                        echo $created_on;
                    } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_PHOTO_TAG) {
                        
                    } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_MENTIONS_POST) {
                        
                    } else if ($notification_info['type_id'] == NOTIFICATION_WHILE_PHOTO_TAG) {
                        
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php }?>
</div>
<div class="pagelet">
    <div class="row">
        <div class="col-md-12">
            <div class="see_all_anchor_style">
                <a href="<?php echo base_url(); ?>notifications/">See All</a>
            </div>
        </div>
    </div>
</div>