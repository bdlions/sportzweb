<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"><!--<![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A social hub that allows you to connect and share health, sports and fitness information with people. Members have access to a variety of health, sports and fitness applications including diets, personal trainers, blogs, food recipes and news.">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="sonuto sonuto.com sport sports news blog blogs recipe food kitchen gym fitnes health service fixture fixtures result results match tournament team"/>
        <meta content="website" property="og:type">
        <meta content="Sonuto" property="og:site_name">
        <meta content="http://www.sonuto.com" property="og:url">
        <link href="http://www.sonuto.com" rel="canonical">
        <meta content="Sonuto - Index/Tab" property="analytics-track">
        <meta content="homepage" property="analytics-s-channel">
        <title itemprop="name">Sonuto</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/property.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/newsfeed.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bg_img_landing.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/bootstrap.min.css">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/html5shiv.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/respond.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
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
        <div class="container-fluid">
            <?php echo $contents; ?>
        </div>
        <?php $this->load->view("common/common_message_modal"); ?>
    </body>
</html>