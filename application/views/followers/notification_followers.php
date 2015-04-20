<div class="pagelet">
    <div class="row">
        <div class="col-md-6">
            <span style="font-size: 12px; font-weight: bold;">Follower Requests</span>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <a style="font-size: 11px;" href="#">Find Followers</a> .
                <a style="font-size: 11px;" href="#">Settings</a> 
            </div>
        </div>
    </div>
</div>
<div class="scroll_box_style">
    <?php foreach ($notification_list as $notification_info) { ?>


        <?php
        $reference_id = $notification_info['reference_id'];
        if ($notification_info['type_id'] == NOTIFICATION_WHILE_START_FOLLOWING) {
            ?>
            <div class="pagelet">
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $notification_info['reference_info']['photo'] ?>">   
                        <a href='<?php echo base_url() . "member_profile/show/{$notification_info['reference_info']['user_id']}" ?>' class="profile-name" ><?php echo $notification_info['reference_info']['first_name'] . " " . $notification_info['reference_info']['last_name']; ?></a>                            
                    </div>
                </div>
            </div>
        <?php }
    }
    ?>
</div>
<div class="pagelet">
    <div class="row">
        <div class="col-md-12">
            <div class="see_all_anchor_style">
                <a href="<?php echo base_url(); ?>followers">See All</a>
            </div>
        </div>
    </div>
</div>