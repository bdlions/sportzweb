<div class="row">
    <div class="col-md-9">
        <a href='<?php echo base_url() . "member_profile/show/{$basic_profile->id}" ?>' class="profile-name"> 
            <div>
                <img alt="<?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W100_H100 . $basic_profile->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('span')[0].style.display='block'; " /> 
                <span style="display: none"><?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?></span>
            </div>
            <div class="member-name"><?php echo $basic_profile->first_name . " " . $basic_profile->last_name ?></div>
        </a>
    </div>
</div>
<!--<div class="row">
    <div class="col-md-9">
        <a href='<?php echo base_url() . "member_profile/show/{$basic_profile->id}" ?>' class="profile-name"> 
            <div>
                <img alt="<?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W100_H100 . $basic_profile->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                <p style="visibility:hidden"><?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?></p>
            </div>
            <div class="member-name"><?php echo $basic_profile->first_name . " " . $basic_profile->last_name ?></div>
        </a>
    </div>
</div>-->
<div class="row">
    <div class="col-md-12">
        <div style="margin: 5px 0px; border-top: 1px solid lightgray"></div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url().'member_profile/show/'.$basic_profile->id ?>">
                <img src="<?php echo base_url() ?>resources/images/7.gif"> Profile
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url().'member_profile/info/'.$basic_profile->id ?>">
                <img src="<?php echo base_url() ?>resources/images/17.gif"> Info
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url().'user_album/photos/'.$basic_profile->id ?>">
                <img src="<?php echo base_url() ?>resources/images/20.gif"> My photos
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url().'followers/show/'.$basic_profile->id ?>">
                <img src="<?php echo base_url() ?>resources/images/2.gif"> Following
            </a>
        </div>
        
    </div>
</div>







<!--
<div class="row col-md-12">
    <div class="row">
        <div class="col-md-9">
           <a href="<?php echo base_url(). "member_profile/show/{$basic_profile->id}"?>" class="profile-name"> 
                <div>
                    <img alt="<?php echo $basic_profile->first_name[0].$basic_profile->last_name[0] ?>" src="<?php echo base_url().PROFILE_PICTURE_PATH_W100_H100.$basic_profile -> photo?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden"><?php echo $basic_profile->first_name[0].$basic_profile->last_name[0] ?></p>
                </div>
                <p class="member-name"><?php echo $basic_profile->first_name. " ". $basic_profile->last_name?></p>
            </a>
        </div>
    </div>
    <div class="panel left-panel">
        <div class="panel-body left-panel-body">
            <ul class="list-group left-panel-list">
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/7.gif"/><a href="<?php echo base_url()?>member_profile/<?php echo (isset($user_id)?  "show/".$user_id :  ""); ?>">Profile</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/17.gif"/><a href="<?php echo base_url()?>member_profile/info/<?php echo (isset($user_id)?  $user_id :  ''); ?>">Info</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/20.gif"/><a href="<?php echo base_url()?>user_album/photos/<?php echo (isset($user_id)?  $user_id :  ''); ?>">My Photos</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/2.gif" height="16px" width="16px"/><a href="<?php echo base_url().'followers/'. (isset($user_id)?  'show/'.$user_id :  '')?>">Following</a>
                </li>
            </ul>
        </div>
    </div>
</div>-->