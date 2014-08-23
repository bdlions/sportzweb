<!DOCTYPE html>
<html lang="en" class="js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <title>Sportzweb</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>resources/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/bootstrap-responsive.min.css" />
        <link href="<?php echo base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>resources/js/bootstrap.js"></script>
        <script src="<?php echo base_url() ?>resources/js/bootstrap.min.js"></script>
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <div class="top">
                        <a href="#"><div class="logo"></div></a>
                    </div>
                </div>
                <div class="span12">
                    <?php
                        echo $contents;
                    ?>
                </div>
                <?php
                $this->load->view("nonmember/templates/footer");
                ?>
            </div>
        </div>
    </body>
</html>