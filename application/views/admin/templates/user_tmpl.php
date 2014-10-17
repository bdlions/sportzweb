<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <title>Sportzweb</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/property.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/newsfeed.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/left-nav.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/admin.css">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/custom_error.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/expanding.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/typeahead.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/hogan-2.0.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/tmpl.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/common.js"></script>
        
        <script type="text/javascript">
            var config = {
               base: "<?php echo base_url(); ?>"
            };
        </script>        
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/jquery.jscroll.js"></script>
                <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/jquery.fileupload.css">

        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="<?php echo base_url() ?>resources/js/vendor/jquery.ui.widget.js"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="<?php echo base_url() ?>resources/js/tmpl.min.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="<?php echo base_url() ?>resources/js/load-image.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="<?php echo base_url() ?>resources/js/canvas-to-blob.min.js"></script>
        <!-- blueimp Gallery script -->
        <script src="<?php echo base_url() ?>resources/js/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="<?php echo base_url() ?>resources/js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="<?php echo base_url() ?>resources/js/jquery.fileupload-validate.js"></script>
        
        
        <script type="text/javascript">
            $(function(){
                $.urlParam = function(name){
                    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results == null){
                       return null;
                    }
                    else{
                       return results[1] || 0;
                    }
                }
                //console.log($.urlParam("menu"));
                var menu = $.urlParam("menu");
                var sub_menu = $.urlParam("sub_menu");
                
                    
                $("#left-nav li").each(function(){
                    var id = $(this).attr("id");
                    if(id == menu || id == (menu + "-" + sub_menu)){
                        $(this).addClass("active");
                    }
                    
                });
            });
        </script>
    </head>

    <body>
        <?php $this->load->view("admin/templates/sections/admin_header");?>

        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="left-nav">
                        <ul id="left-nav">
                            <?php 
                            if(array_key_exists(ADMIN_ACCESS_LEVEL_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="overview">
                                <a href="<?php echo base_url()?>admin/overview_show">Overview</a>
                            </li>
                            <?php 
                            }if(
                                    array_key_exists(ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="users">
                                <a href="#">Users</a>
                                <ul>
                                    <?php 
                                    if(array_key_exists(ADMIN_ACCESS_LEVEL_USERS_OVERVIEW_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="users_overview"><a href="<?php echo base_url()?>admin/users_overview">Overview</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_USERS_USER_MANAGE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="users_user_manage"><a href="<?php echo base_url()?>admin/users_usermanage">User Manage</a></li>                                    
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php 
                            }if(
                                    array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping) 
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>                            
                            <li id="applications">
                                <a href="<?php echo base_url()?>admin/application/application_manage">Applications</a>
                                <ul>
                                    <?php 
                                    if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_directory"><a href="<?php echo base_url()?>admin/applications_directory">App Directory</a></li> 
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_XSTREAM_BANTER_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_xstreambanter"><a href="<?php echo base_url()?>admin/applications_xstreambanter">Xstream Banter</a></li> 
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_healthyrecipes"><a href="<?php echo base_url()?>admin/applications_healthyrecipes">Healthy Recipes</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_SERVICE_DIRECTORY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_servicedirectory"><a href="<?php echo base_url()?>admin/applications_servicedirectory">Service Directory</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_news"><a href="<?php echo base_url()?>admin/applications_news">News</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_blogs"><a href="<?php echo base_url()?>admin/applications_blogs">Blogs</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_bmicalculator"><a href="<?php echo base_url()?>admin/applications_bmicalculator">BMI Calculator</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_PHOTOGRAPHY_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="applications_photography"><a href="<?php echo base_url()?>admin/applications_photography">Photography</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php 
                            }if(array_key_exists(ADMIN_ACCESS_LEVEL_BUSINESS_PROFILES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="business_profiles">
                                <a href="<?php echo base_url()?>admin/businessprofiles_show">Business Profiles</a>
                            </li>
                            <?php 
                            }if(
                                    array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping)
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping)
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="visitors">
                                <a href="#">Visitors</a>
                                <ul>
                                    <?php 
                                    if(array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_PAGES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="visitors_page"><a href="<?php echo base_url()?>admin/visitors_page">Page</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_APPLICATIONS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="visitors_application"><a href="<?php echo base_url()?>admin/visitors_application">Application</a></li>                                    
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_VISITORS_BUSINESS_PROFILE_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="visitors_business_profile"><a href="<?php echo base_url()?>admin/visitors_businessprofile">Business Profile</a></li>                                    
                                    <?php } ?>
                                </ul>
                            </li> 
                            <?php 
                            }if(
                                    array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping)
                                    || array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="footer">
                                <a href="#">Footer</a>
                                <ul>
                                    <?php 
                                    if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="manage_new_user"><a href="<?php echo base_url()?>admin/footer/about_us">About Us</a></li>
                                    <?php 
                                    }if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_CONTACT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                                    {?>
                                    <li id="manage_contact_us"><a href="<?php echo base_url()?>admin/contact_us">Contact Us</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php 
                            }if(array_key_exists(ADMIN_ACCESS_LEVEL_LOG_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
                            {?>
                            <li id="log">
                                <a href="<?php echo base_url()?>admin/log_view">Log</a>
                            </li>
                            <?php } ?>
                            <li id="settings">
                                <a href="<?php echo base_url()?>admin/auth/logout">Logout</a>                                
                            </li> 
                        </ul>
                    </div>
                </div>
                <div class="col-md-10 column">
                    <div class="row">
                        <?php echo $contents; ?>
                    </div>
                </div>
         
            </div>
        </div>
        <?php //$this->load->view("templates/sections/footer");?>
    </body>
</html>
