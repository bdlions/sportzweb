<nav class="navbar navbar-default navbar-top" role="navigation">
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
                <div class="col-md-4 logo-text">
                    <img class="logo" src="<?php echo base_url() ?>/resources/images/logo1.png" />Sonuto
                </div>
                <div class="col-md-8 login12">
                    <?php echo form_open("auth/login", array('class' => 'navbar-right', 'style' => 'min-width:590px;', 'id' => 'login_box')); ?>
                    <div class="row login_port">
                        <div class="col-md-4 login_width">
                            <div class="row">
                                <?php echo lang('login_identity_label'); ?>
                            </div>
                            <div class="row">
                                <?php echo form_input($identity + array('class' => 'form-control login-textbox')); ?>
                            </div>
                        </div>
                        <div class="col-md-4 login_width">
                            <div class="row">
                                <?php echo lang('login_password_label'); ?><?php echo anchor("auth/forgot_password", "Forgot your password?", $forget_password); ?>
                            </div>
                            <div class="row">
                                <?php echo form_input($password + array('class' => 'form-control login-textbox')); ?>
                            </div>
                        </div>
                        <div class="col-md-2 signin_button">
                            <div class="row">
                                &nbsp;
                            </div>
                            <div class="row">
                                <?php echo form_input($login_btn + array('class' => 'btn button-custom')); ?>
                            </div>

                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</nav>