<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman,Omar Faruk">
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
                            <li id="overview">
                                <a href="<?php echo base_url()?>admin/overview_show">Overview</a>
                            </li>
                            <li id="users">
                                <a href="#">Users</a>
                                <ul>
                                    <li id="users_overview"><a href="<?php echo base_url()?>admin/users_overview">Overview</a></li>
                                    <li id="users_user_manage"><a href="<?php echo base_url()?>admin/users_usermanage">User Manage</a></li>                                    
                                </ul>
                            </li>
                            <li id="applications">
                                <a href="<?php echo base_url()?>admin/application/application_manage">Applications</a>
                                <ul>
                                    <li id="applications_xstreambanter"><a href="<?php echo base_url()?>admin/applications_xstreambanter">Xstream Banter</a></li> 
                                    <li id="applications_healthyrecipes"><a href="<?php echo base_url()?>admin/applications_healthyrecipes">Healthy Recipes</a></li>
                                    <li id="applications_servicedirectory"><a href="<?php echo base_url()?>admin/applications_servicedirectory">Service Directory</a></li>
                                    <li id="applications_news"><a href="<?php echo base_url()?>admin/applications_news">News</a></li>
                                    <li id="applications_blogs"><a href="<?php echo base_url()?>admin/applications_blogs">Blogs</a></li>
                                    <li id="applications_bmicalculator"><a href="<?php echo base_url()?>admin/applications_bmicalculator">BMI Calculator</a></li>
                                    <li id="applications_photography"><a href="<?php echo base_url()?>admin/applications_photography">Photography</a></li>
                                </ul>
                            </li>
                            <li id="business_profiles">
                                <a href="<?php echo base_url()?>admin/businessprofiles_show">Business Profiles</a>
                            </li>
                            <li id="visitors">
                                <a href="#">Visitors</a>
                                <ul>
                                    <li id="visitors_page"><a href="<?php echo base_url()?>admin/visitors_page">Page</a></li>
                                    <li id="visitors_application"><a href="<?php echo base_url()?>admin/visitors_application">Application</a></li>                                    
                                    <li id="visitors_business_profile"><a href="<?php echo base_url()?>admin/visitors_businessprofile">Business Profile</a></li>                                    
                                </ul>
                            </li>
                            <li id="configure">
                                <a href="<?php echo base_url()?>admin/configure_login_page">Configure</a>
                                <ul>
                                    <li id="configure_login_page"><a href="<?php echo base_url()?>admin/configure_login_page">Login Page</a></li>
                                    <li id="configure_logout_page"><a href="<?php echo base_url()?>admin/configure_logout_page">Logout Page</a></li>
                                </ul>
                            </li>
                            <li id="log">
                                <a href="<?php echo base_url()?>admin/log_view">Log</a>
                            </li>
                            <li id="manage">
                                <a href="<?php echo base_url()?>admin/access_level">Access</a>
                                <ul>
                                    <li id="manage_new_user"><a href="<?php echo base_url()?>admin/access_level">New User</a></li>
                                    <li id="manage_show_users"><a href="<?php echo base_url()?>admin/access_level/show_users">Show Users</a></li>
                                    <li id="manage_create_access_level"><a href="<?php echo base_url()?>admin/access_level/create_access_level">Create Access Level </a></li>
                                </ul>
                            </li>
                            <li id="footer">
                                <a href="<?php echo base_url()?>admin/footer/about_us">Footer</a>
                                <ul>
                                    <li id="manage_new_user"><a href="<?php echo base_url()?>admin/footer/about_us">About Us</a></li>
                                    <li id="manage_contact_us"><a href="<?php echo base_url()?>admin/contact_us">Contact Us</a></li>
                                </ul>
                            </li>
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
