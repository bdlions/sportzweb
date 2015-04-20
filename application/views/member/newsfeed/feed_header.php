<?php if($newsfeed['shared_type_id'] == STATUS_SHARE_OTHER_STATUS && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared </span>
    <?php if($newsfeed['user_id'] != $newsfeed['reference_info']['user_id']){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['reference_info']['user_id']}"?>' class="profile-name" ><?php echo $newsfeed['reference_info']['first_name'] . " ". $newsfeed['reference_info']['last_name'] ?>'s </a>
    <?php }else{ echo 'a'; } ?>
    <a href="<?php echo base_url().'member_profile/view_shared_status/'.$newsfeed['reference_info']['status_id'];?>">
        <?php 
            if (strpos($newsfeed['reference_info']['description'], 'youtube.com') !== false) {
                echo '<span class="shared-text">video</span>';
            }
            else
            {
                echo '<span class="shared-text">status</span>';
            }
        ?>
    </a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_HEALTHY_RECIPE && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_HEALTHY_RECIPE_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
    <?php if (!empty($newsfeed['via_user_info'])) { ?>
    <span class="shared-text">via </span> 
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['via_user_info']['user_id']}"?>' class="profile-name" ><?php echo $newsfeed['via_user_info']['first_name'] . " ". $newsfeed['via_user_info']['last_name'] ?></a>
    <?php }?>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_SERVICE_DIRECTORY && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_SERVICE_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_NEWS && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_NEWS_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_BLOG && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_PHOTO && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared </span>
    <?php if($newsfeed['user_id'] != $newsfeed['reference_info']['user_id']){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['reference_info']['user_id']}"?>' class="profile-name" ><?php echo $newsfeed['reference_info']['first_name'] . " ". $newsfeed['reference_info']['last_name'] ?>'s</a>
    <?php }else{ echo 'a'; } ?>
    <span class="shared-text"> photo</span>
<?php }else if($newsfeed['status_type_id'] == STATUS_TYPE_PROFILE_PIC_CHANGE){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text"> changed his </span>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" > profile picture </a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PTPRO && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().GYMPRO_HOME_PAGE_PATH?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_BMI_CALCULATOR && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().BMI_HOME_PAGE_PATH?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_PHOTOGRAPHY && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().PHOTOGRAPHY_HOME_PAGE_PATH?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_APP_ADMIN_LATEST_MAIN_RECIPE && isset($newsfeed['reference_info']) ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_HEALTHY_RECIPE_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG1 ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG2 ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG3 ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else if($newsfeed['shared_type_id'] == STATUS_SHARE_LATEST_BLOG4 ){ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>
    <span class="shared-text">shared a</span>
    <a href="<?php echo base_url().APPLICATION_BLOG_PATH.$newsfeed['reference_info']['id'];?>"><span class="shared-text">link</span></a>
<?php }else{ ?>
    <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>' class="profile-name" >
        <span class="content_text"><?php echo $newsfeed['first_name'] . " ". $newsfeed['last_name'] ?></span>
    </a>    
<?php }?>
