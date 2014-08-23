<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman, Omar Faruk,Redwan khaled,Tanveer">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sportzweb</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/property.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/newsfeed.css">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/html5shiv.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/respond.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/custom_error.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/expanding.js"></script>
        <script type="text/javascript" src="http://twitter.github.com/hogan.js/builds/2.0.0/hogan-2.0.0.js"></script>
        
    </head>
    <body class="back">
        <?php $this->load->view("templates/sections/header_with_login");?>
        <div class="container">
            <div class="row">
                <?php echo $contents; ?>
            </div>
        </div>
        <?php $this->load->view("templates/sections/footer");?>
    </body>
</html>