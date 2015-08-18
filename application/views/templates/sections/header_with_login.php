<nav class="navbar navbar-default navbar-fixed-top navbar-top" role="navigation" style="z-index: 999999;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div>

    <div class="collapse navbar-collapse" id="open-collapse">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 logo-text logo_text_modify">
                    <a href="<?php echo base_url(); ?>" ><img class="logo_modified" src="<?php echo base_url() ?>/resources/images/logo1.png" /><?php echo WEBSITE_TITLE; ?></a>
                </div>
                <div class="col-md-8 col-sm-8">
                    <?php echo form_open("auth/login", array('id' => 'login_box')); ?>
                    <div class="row form-group login_text_style">
                        <div class="col-sm-5 col-md-offset-2 col-md-4">
                            <?php echo lang('login_identity_label'); ?>
                            <?php echo form_input($identity + array('class' => 'form-control input_custom_style')); ?>
                        </div>
                        <div class="col-sm-5 col-md-4">
                            <?php echo lang('login_password_label'); ?><?php echo anchor("auth/forgot_password", "Forgot your password?", $forget_password); ?>
                            <?php echo form_input($password + array('class' => 'form-control input_custom_style')); ?>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <br>
                            <?php echo form_input($login_btn + array('class' => 'btn button-custom form-control')); ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</nav>