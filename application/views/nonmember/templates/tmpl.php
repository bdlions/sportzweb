<!DOCTYPE html>
<html lang="en" class="js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman, Omar Faruk,Redwan khaled,Tanveer">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <title>Sportzweb</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/styles.css" />

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/custom_error.js"></script>
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <div class="top">
                        <a href="<?php echo base_url();?>"><div class="logo"></div></a>
                        <?php
                        $this->load->view("nonmember/templates/header_with_login");
                        ?>
                    </div>
                </div>

                <div id="infoMessage"><?php echo $message; ?></div>
                <div class="span12">
                    <div class="index">
                        <div class="main">
                            <div class="home-left">
                                <div class="home-left-tit"><h1 class="home-left-title">Sign Up</h1></div>
                                <?php
                                echo $contents;
                                ?>
                            </div>
                            <div class="home-right" style="text-align: left;padding-left: 10px;"><img src="<?php echo base_url() ?>resources/images/index1376265189.jpg" style="margin-top:30px;height:auto;"><div style="width:100%; font-weight:bold; text-align:left; padding-left:5px;">Timothy Ward - Krisana Thai Boxing Gym</div></div>
                        </div>
                    </div>
                </div>
                <?php
                $this->load->view("nonmember/templates/footer");
                ?>
            </div>
        </div>
    </body>
</html>