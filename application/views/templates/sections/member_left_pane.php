<div class="row col-md-12">
    <div class="row">
        <div class="col-md-9">
            <a href='<?php echo base_url(). "member_profile/show/{$basic_profile->id}"?>' class="profile-name"> 
                <div>
                    <img alt="<?php echo $basic_profile->first_name[0].$basic_profile->last_name[0] ?>" src="<?php echo base_url().PROFILE_PICTURE_PATH_W100_H100.$basic_profile -> photo?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden"><?php echo $basic_profile->first_name[0].$basic_profile->last_name[0] ?></p>
                </div>
                <p class="member-name"><?php echo $basic_profile->first_name. " ". $basic_profile->last_name?></p>
            </a>
        </div>
    </div>
    

    <div class="panel left-panel">
        <div class="panel-heading left-panel-heading">Favourites</div>
        <div class="panel-body left-panel-body">
            <ul class="list-group left-panel-list">
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/Share.gif"/><a class="icon-heart" href="#">News Feed</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/7.gif"/><a href="<?php echo base_url()?>member_profile/">Profile</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/17.gif"/><a href="<?php echo base_url()?>messages">Message</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/2.gif"/><a href="<?php echo base_url()?>followers">Followers</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel left-panel">
        <div class="panel-heading left-panel-heading">Application</div>
        <div class="panel-body left-panel-body">
            <ul class="list-group left-panel-list">
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/xb_icon.png"/><a href="<?php echo base_url().'applications/xstream_banter' ?>">Xstream Banter</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/saddress_book.png"/><a href="<?php echo base_url().'applications/healthy_recipes' ?>">Healthy Recipes</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/mapservice16.png"/><a href="<?php echo base_url().'applications/service_directory' ?>">Service Directory</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/saddress_book.png"/><a href="#">Sports</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/045631686.gif"/><a href="<?php echo base_url().'applications/blog_app' ?>"></i>Blogs</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/newspaper.png"/><a href="<?php echo base_url().'applications/news_app' ?>"></i>News</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url(); ?>resources/images/bmi_calculator.png" height="16px" width="16px"/><a href="<?php echo base_url().'applications/bmi_calculator' ?>"></i>BMI Calculator</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url(); ?>resources/images/camera-icon.png" height="16px" width="16px"/><a href="<?php echo base_url().'applications/photography' ?>"></i>Photography</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/calendar.png"/><a href="#">Events</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/gnome_system_users.png"/><a href="#">Buddy</a>
                </li>
                <li class="list-group-item left-panel-item list-icon">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/shop_16.png"/><a href="#">Shop</a>
                </li>
            </ul>
        </div>
    </div>
</div>