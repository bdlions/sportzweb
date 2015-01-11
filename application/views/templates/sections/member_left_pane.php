<div class="row">
    <div class="col-md-9">
        <a href='<?php echo base_url() . "member_profile/show/{$basic_profile->id}" ?>' class="profile-name"> 
            <div>
                <img alt="<?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W100_H100 . $basic_profile->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                <p style="visibility:hidden"><?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?></p>
            </div>
            <p class="member-name"><?php echo $basic_profile->first_name . " " . $basic_profile->last_name ?></p>
        </a>
    </div>
</div>
<div class="menu_divider"></div>
<div class="row">
    <div class="col-md-12">
        <h4>Favourites</h4>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>">
                <img src="<?php echo base_url() ?>resources/images/Share.gif"> News Feed
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>member_profile">
                <img src="<?php echo base_url() ?>resources/images/7.gif"> Profile
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>messages">
                <img src="<?php echo base_url() ?>resources/images/17.gif"> Message
            </a>
        </div>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>followers">
                <img src="<?php echo base_url() ?>resources/images/2.gif"> Followers
            </a>
        </div>
        
    </div>
</div>
<div class="menu_divider"></div>
<div class="row">
    <div class="col-md-12">
        <h4>Applications</h4>
        <?php if (in_array(APPLICATION_XSTREAM_BANTER_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/xstream_banter">
                <img src="<?php echo base_url() ?>resources/images/xb_icon.png"> Xstream Banter
            </a>
        </div>
        <?php } if (in_array(APPLICATION_HEALTYY_RECIPES_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/healthy_recipes">
                <img src="<?php echo base_url() ?>resources/images/saddress_book.png"> Healthy Recipes
            </a>
        </div>
        <?php } if (in_array(APPLICATION_SERVICE_DIRECTORY_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/service_directory">
                <img src="<?php echo base_url() ?>resources/images/mapservice16.png"> Service Directory
            </a>
        </div>
        <?php } if (in_array(100, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/service_directory">
                <img src="<?php echo base_url() ?>resources/images/saddress_book.png"> Sports
            </a>
        </div>
        <?php } if (in_array(APPLICATION_BLOG_APP_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/blog_app">
                <img src="<?php echo base_url() ?>resources/images/045631686.gif"> Blogs
            </a>
        </div>
        <?php } if (in_array(APPLICATION_NEWS_APP_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/news_app">
                <img src="<?php echo base_url() ?>resources/images/newspaper.png"> News
            </a>
        </div>
        <?php } if (in_array(APPLICATION_BMI_CALCULATOR_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/bmi_calculator">
                <img src="<?php echo base_url() ?>resources/images/bmi_calculator.png"> BMI Calculator
            </a>
        </div>
        <?php } if (in_array(APPLICATION_PHOTOGRAPHY_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/photography">
                <img src="<?php echo base_url() ?>resources/images/camera-icon.png"> Photography
            </a>
        </div>
        <?php } if (in_array(APPLICATION_GYMPRO_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/gympro">
                <img src="<?php echo base_url() ?>resources/images/ptpro.png"> PT Pro
            </a>
        </div>
        <?php } if (in_array(APPLICATION_SHOP_ID, $app_id_list)) { ?>
        <div class="left_menu_item" >
            <a href="<?php echo base_url()?>applications/gympro">
                <img src="<?php echo base_url() ?>resources/images/shop_16.png"> Shop
            </a>
        </div>
        <?php } ?>
    </div>
</div>
<!--
<div class="row col-md-12">
    <div class="row">
        <div class="col-md-9">
            <a href='<?php echo base_url() . "member_profile/show/{$basic_profile->id}" ?>' class="profile-name"> 
                <div>
                    <img alt="<?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W100_H100 . $basic_profile->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden"><?php echo $basic_profile->first_name[0] . $basic_profile->last_name[0] ?></p>
                </div>
                <p class="member-name"><?php echo $basic_profile->first_name . " " . $basic_profile->last_name ?></p>
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
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/7.gif"/><a href="<?php echo base_url() ?>member_profile/">Profile</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/17.gif"/><a href="<?php echo base_url() ?>messages">Message</a>
                </li>
                <li class="list-group-item left-panel-item">
                    <img class="list-icon" src="<?php echo base_url() ?>resources/images/2.gif" height="16px" width="16px"/><a href="<?php echo base_url() ?>followers">Followers</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="panel left-panel">
        <div class="panel-heading left-panel-heading">Application</div>
        <div class="panel-body left-panel-body">
            <ul class="list-group left-panel-list">
                <?php
                if (in_array(APPLICATION_XSTREAM_BANTER_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/xb_icon.png"/><a href="<?php echo base_url() . 'applications/xstream_banter' ?>">Xstream Banter</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_HEALTYY_RECIPES_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/saddress_book.png"/><a href="<?php echo base_url() . 'applications/healthy_recipes' ?>">Healthy Recipes</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_SERVICE_DIRECTORY_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/mapservice16.png"/><a href="<?php echo base_url() . 'applications/service_directory' ?>">Service Directory</a>
                    </li>
                    <?php
                }if (in_array(100, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/saddress_book.png"/><a href="#">Sports</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_BLOG_APP_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/045631686.gif"/><a href="<?php echo base_url() . 'applications/blog_app' ?>"></i>Blogs</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_NEWS_APP_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/newspaper.png"/><a href="<?php echo base_url() . 'applications/news_app' ?>"></i>News</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_BMI_CALCULATOR_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url(); ?>resources/images/bmi_calculator.png" height="16px" width="16px"/><a href="<?php echo base_url() . 'applications/bmi_calculator' ?>"></i>BMI Calculator</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_PHOTOGRAPHY_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url(); ?>resources/images/camera-icon.png" height="16px" width="16px"/><a href="<?php echo base_url() . 'applications/photography' ?>"></i>Photography</a>
                    </li>
                    <?php
                }if (in_array(APPLICATION_GYMPRO_ID, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url(); ?>resources/images/ptpro.png" height="16px" width="16px"/><a href="<?php echo base_url() . 'applications/gympro' ?>"></i>PT Pro</a>
                    </li>
                    <?php
                }if (in_array(100, $app_id_list)) {
                    ?>
                    <li class="list-group-item left-panel-item list-icon">
                        <img class="list-icon" src="<?php echo base_url() ?>resources/images/shop_16.png"/><a href="#">Shop</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
-->