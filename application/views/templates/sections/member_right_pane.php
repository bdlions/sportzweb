<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/newsfeed.css">
<link type="text/css" href="<?php echo base_url(); ?>resources/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.jscrollpane.min.js"></script>
<script>
    $(function(){
       
        $('.right-panel-list').jScrollPane({
    //    $('.content-area').jScrollPane({
            horizontalGutter:5,
            verticalGutter:5,
            'showArrows': false
        });
        $('.jspDrag').hide();
        $('.jspScrollable').mouseenter(function(){
            $(this).find('.jspDrag').stop(true, true).fadeIn('fast');
            $('.jspHorizontalBar').hide();
        });
        $('.jspScrollable').mouseleave(function(){
            $(this).find('.jspDrag').stop(true, true).fadeOut('slow');
        });
 
    });
</script>
<style>
    .jspVerticalBar {
        width: 8px;
        background: transparent;
        right:10px;
    }

    .jspHorizontalBar {
        bottom: 5px;
        width: 100%;
        height: 8px;
        background: transparent;
    }
    .jspTrack {
        background: transparent;
    }

    .jspDrag {
        background: url(<?php echo base_url(); ?>resources/images/transparent-black.png) repeat;
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }

    .jspHorizontalBar .jspTrack,
    .jspHorizontalBar .jspDrag {
        float: left;
        height: 100%;
    }

    .jspCorner {
        display:none
    }
    
</style>
<div class="row">
    <div class="col-md-12">
        <div class="right-panel-container">
            <div class="panel right-panel">
                <div class="panel-heading right-panel-heading">Recent Activity</div>
                <div class="panel-body right-panel-body">
                    <div class="container-fluid right-panel-list">
                    <div style="padding-bottom: 30px">
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_LIKES]['from_user_info']) && !empty($recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_LIKES]['to_user_info']['last_name'] ?></a> likes <a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_LIKES]['from_user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_LIKES]['from_user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_LIKES]['from_user_info']['last_name'] ?></a>'s status</div>
                                </div>
                            </div>
                        <?php } ?> 
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']) && !empty($recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_PHOTOS]['photo_info']['user_info']['last_name'] ?></a> Added a new photo</div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']) && !empty($recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['follower_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['user_info']['last_name'] ?></a> is now following <a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['follower_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['follower_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_FOLLOWERS]['follower_info']['last_name'] ?></a></div>
                                </div>
                            </div>
                        <?php } ?> 
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_STATUS]['status_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_STATUS]['status_info']['user_info']['last_name'] ?></a> posted a status</div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_COMMENTS]['from_user_info']) && !empty($recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['to_user_info']['last_name'] ?></a> commented on <a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['from_user_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_COMMENTS]['from_user_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_COMMENTS]['from_user_info']['last_name'] ?></a>'s status</div>
                                </div>
                            </div>
                        <?php } ?> 
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_CONNECTIONS])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_CONNECTIONS][0]['last_name'] ?></a> is now connected to Sonuto</div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!empty($recent_activities[RECENT_ACTIVITIES_BLOGS]) && !empty($recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info'])) { ?>
                            <div class="list-group-item right-panel-item">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4 col-lg-4">
                                        <a href='<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['user_id'] ?>' class="profile-name"> 
                                            <div>
                                                <img alt="<?php echo $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('div')[0].style.visibility='visible';" /> 
                                                <div style="visibility:hidden;height:0px"><?php echo $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['first_name'][0] . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['last_name'][0] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-md-8 col-xs-8 col-lg-8"><a href="<?php echo base_url() . "member_profile/show/" . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['user_id'] ?>"><?php echo $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['first_name'] . ' ' . $recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['last_name'] ?></a> created a <a href="<?php echo base_url().'applications/blog_app/view_blog_post/'.$recent_activities[RECENT_ACTIVITIES_BLOGS]['blog_info']['blog_id']; ?>">blog</a></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    </div>
                </div>
            </div>  
            <!--<div class="panel right-panel">
                <div class="panel-heading right-panel-heading">Suggested People
                    <div class="pull-right">
                        <a href="<?php echo base_url(); ?>feed/seeAllSuggestedPeople">see all</a>
                    </div>
                </div>
                <div class="panel-body right-panel-body">
                    <div class="row right-panel-listitem-suggested-people">
                        <a href="<?php echo base_url(); ?>">
                            <div class="col-md-3">
                                <img class="list-icon" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $user['photo'] ?>" />
                            </div>
                            <div class="col-md-5">Andy Callister
                            </div>
                            <div class="col-md-4 btn-group pull-right">
                                <button type="button" class="btn btn-default">
                                    Follow 
                                </button>
                            </div>
                        </a>
                    </div>
                    <div class="row right-panel-listitem-suggested-people">
                        <a href="<?php echo base_url(); ?>">
                            <div class="col-md-3">
                                <img class="list-icon" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $user['photo'] ?>" />
                            </div>
                            <div class="col-md-5">Andy Callister
                            </div>
                            <div class="col-md-4 pull-right">
                                <button type="button" class="btn btn-default">
                                    Follow 
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid #000;"></div>-->
            
            <div class="panel right-panel">
                <div class="panel-body right-panel-body" style="padding-bottom: 20px;">
                    <div class="panel-heading right-panel-heading">
                        <div class="row">
                            <div class="col-md-8 pull-left">App Directory</div>
                            <div class="col-md-4 pull-right">
                                <a href="<?php echo base_url(); ?>applications/application_directory">
                                    See all
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body right-panel-body">
                    
                    <ul class="list-inline list-unstyled">
                        <?php foreach($applications_info as $application_info){ ?>
                            <?php if($application_info['id'] == APPLICATION_XSTREAM_BANTER_ID) { ?>
                            <li>
                                <a href="<?php echo base_url().XSTREAM_BANTER_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.XSTREAM_BANTER_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>    
                            <?php } elseif ($application_info['id'] == APPLICATION_HEALTYY_RECIPES_ID) {?>
                            <li>
                                <a href="<?php echo base_url().HEALTHY_RECIPE_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.HEALTHY_RECIPE_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>    
                            <?php } elseif ($application_info['id'] == APPLICATION_SERVICE_DIRECTORY_ID) {?>
                            <li>
                                <a href="<?php echo base_url().SERVICE_DIRECTORY_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.SERVICE_DIRECTORY_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>    
                            <?php } elseif ($application_info['id'] == APPLICATION_BLOG_APP_ID) {?>
                            <li>
                                <a href="<?php echo base_url().BLOG_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.BLOG_ICON?>" height="16px" width="16px"/>
                                </a>
                            </li>    
                            <?php } elseif ($application_info['id'] == APPLICATION_NEWS_APP_ID) {?>
                            <li>
                                <a href="<?php echo base_url().NEWS_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.NEWS_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>    
                            <?php } elseif ($application_info['id'] == APPLICATION_BMI_CALCULATOR_ID) {?>
                            <li>
                                <a href="<?php echo base_url().BMI_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.BMI_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>     
                            <?php } elseif ($application_info['id'] == APPLICATION_PHOTOGRAPHY_ID) {?>
                            <li>
                                <a href="<?php echo base_url().PHOTOGRAPHY_HOME_PAGE_PATH?>">
                                    <img alt="<?php echo $application_info['title']; ?>" title="<?php echo $application_info['title']; ?>" src="<?php echo base_url().APPLICATION_ICON_PATH.PHOTOGRAPHY_ICON ?>" height="16px" width="16px"/>
                                </a>
                            </li>
                            <?php } ?>
                        <?php }?>                        
                    </ul>
                    </div>
                </div>
            </div>
            <!--<div class="panel right-panel">
                <div class="panel-heading right-panel-heading">Suggested Interests</div>
                <div class="panel-body right-panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img class="list-icon" src="http://getbootstrap.com/docs-assets/ico/favicon.png" />
                        </div>
                        <div class="col-md-5">IT Support
                        </div>
                        <div class="col-md-4 btn-group">
                            <div class="pull-right">
                                <button type="button" class="btn btn-default dropdown-toggle">
                                    Join <span class="caret"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
    
    <!--<div class="col-md-12" style="padding-top: 10px;">
        <div class="right-panel-container">
            <div class="row">
                <div class="col-md-12" style="padding-top: 10px;">
                    <div class="col-md-8" style="padding-left:0px; font-size: 20px;">
                        App Directory
                    </div>
                    <div class="col-md-4" style="margin-top: 5px;">
                    <a class="" style="font-size: 15px;" href="<?php echo base_url(); ?>app_directory">
                        See all
                    </a>
                </div>
                </div>
                
                <div class="col-md-12" style="padding-top:20px; font-size: 15px; padding-bottom: 10px;">
                    <span>
                        5 new featured apps added to the App Directory this week. 
                    </span>
                </div>
            </div> 
        </div>
    </div>-->
    
    <div class="col-md-12" style="padding-top: 10px;">
        <div class="right-panel-container">
            <div class="panel right-panel">
                <div class="panel-heading right-panel-heading">Trending</div>
                <div class="panel-body right-panel-body">
                    <ul class="list-group right-panel-list">
                        <?php foreach($popular_trends as $trend){?>
                        <li><a href="<?php echo base_url().'trending_feature/hashtag/'.$trend['hashtag']?>">#<?php echo $trend['hashtag']?></a></li>  
                        <?php } ?>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
</div>