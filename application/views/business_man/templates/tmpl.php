<!DOCTYPE html>
<html lang="en" class="js no-flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Social">
        <meta name="author" content="Nazmul Hasan, Alamgir Kabir, Noor Alam, Ziaur Rahman">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="keywords" content=""/>
        <title><?php echo WEBSITE_TITLE?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/master.css">

        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).tooltip();
                $.validator.setDefaults({
                    success: function(label, element) {
                        $(element).closest('.control-group').removeClass('error').addClass('success');
                    },
                    highlight: function(element) {
                        $(element).closest('.control-group').removeClass('success').addClass('error');
                    },
                    unhighlight: function(element) {
                        $(element).closest('.control-group').removeClass('error');
                    },
                    errorElement: 'span',
                    errorClass: 'help-block',
                    errorPlacement: function(error, element) {
                        $(element).attr("title", error.text());
                    }
                });
            });

        </script>
    </head>
    <body screen_capture_injected="true" cz-shortcut-listen="true">
        <div class="top">
            <a href="#"><div class="logo" onclick="window.location = '/'"></div></a>
        </div>
        <div id="mainContainer">
            <?php echo $contents ?>
        </div>
        <?php $this->load->view("member/templates/footer");?>
    </body>
</html>