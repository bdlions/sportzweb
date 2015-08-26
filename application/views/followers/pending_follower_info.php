<div class="col-md-5 form-group">
    <div style="border: 1px solid lightgray; padding: 10px">

        <div class="row">
            <div class="col-md-3">
                <a href='<?php echo base_url() . "member_profile/show/{$follower->user_id}" ?>' class="profile-name"> 
                    <div>
                        <img alt="<?php echo $follower->first_name[0] . $follower->last_name[0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $follower->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible'; " /> 
                        <div style="visibility:hidden; height: 0;"><?php echo $follower->first_name[0] . $follower->last_name[0] ?></div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <div class="row heading_medium_thin">
                    <div class="col-md-12"><?php echo $follower->first_name . " " . $follower->last_name ?></div>
                </div>
                <div class="row small_text_pale">
                    <div class="col-md-12"><?php $follower_count = count(json_decode($follower->relations));
echo $follower_count == 1 ? "{$follower_count} Follower" : "{$follower_count} Followers" ?></div>
                </div>
                <div class="row small_text_pale">
                    <div class="col-md-12"><?php echo $follower->about_me ?></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dropdown friends-satus-dropdown pull-right">
                    <a id="friends_status" data-toggle="dropdown" href="#" >
                        <img src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_accept_confirm('<?php echo $follower->user_id; ?>')">Accept Request</a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_block_confirm('<?php echo $follower->user_id; ?>')">Block</a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_report('<?php echo $follower->user_id; ?>')">Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-1">    
</div>