<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"><!--<![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman, Omar Faruk,Redwan khaled,Tanveer">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--Auth Background sliding Image-->
        <meta name="description" content="Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow" />
        <meta name="keywords" content="css3, css-only, fullscreen, background, slideshow, images, content" />
        <meta name="author" content="Codrops" />
        <title>Sonuto</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/property.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/newsfeed.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bg_img_sliding.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/bootstrap.min.css">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/html5shiv.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/respond.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/modernizr.custom.86080.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/custom_error.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/expanding.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/hogan-2.0.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/general.js"></script>
    </head>
    <body class="back">
        <?php $this->load->view("templates/sections/header_with_login"); ?>
        <div class="container">
            <?php echo $contents; ?>
        </div>
        <?php $this->load->view("templates/sections/footer"); ?>
        <?php $this->load->view("common/common_message_modal"); ?>
    </body>
</html>