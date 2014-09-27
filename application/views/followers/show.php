<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>
<div class="col-md-9 column">
    <?php if($my_user_id == $user_id){?>
        <?php $this->load->view("followers/template/section/member_header"); ?>
    <?php } ?>
    <?php
    $follower_count = 0;
    foreach ($followers as $follower) 
    {
        if ($follower_count % 2 == 0) {?>
            <div class="row" style="padding-top: 10px;">
                <?php $this->load->view("followers/follower_info", array("follower" => $follower, 'user_id' => $user_id, 'current_user_id' => $current_user_id));
        }else {
                $this->load->view("followers/follower_info", array("follower" => $follower, 'user_id' => $user_id, 'current_user_id' => $current_user_id));?>
            </div>
        <?php } 
        $follower_count++;
    }
    if ($follower_count % 2 == 0)
    {
        echo '</div>';
    } 
    ?>
</div>
<?php $this->load->view("followers/modal_report");
