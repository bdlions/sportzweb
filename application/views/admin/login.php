<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/admin.css" />
<div class="col-md-9 padding_over_admin_img">
    <div class="container">
        <div class="row">
            <div class ="col-md-4 col-md-offset-4" style="background-image:url(<?php echo base_url(); ?>/resources/images/loginBG.jpg);background-repeat:no-repeat;background-size: 100% 100%;">
                <div class =" row">
                    <div class ="col-md-12">
                        <h1><?php echo lang('login_admin_heading'); ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class ="col-md-12 login-subheading">
                        <?php echo lang('login_admin_subheading'); ?>
                    </div>
                </div>

                <div id="message" ><?php echo $message; ?></div>

                <?php echo form_open(ADMIN_LOGIN_SUCCESS_URI, array('id' => 'admin-login', 'role' => 'form', 'class' => 'form-horizontal')); ?>
                <div class="form-group">
                    <label for="identity" class="col-md-4 control-label requiredField">
                        <?php echo lang('login_identity_label', 'identity'); ?>
                    </label>
                    <div class ="col-md-6">
                        <?php echo form_input($identity + array('class' => 'form-control')); ?>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label requiredField">
                        <?php echo lang('login_password_label', 'password'); ?>
                    </label>
                    <div class ="col-md-6">
                        <?php echo form_input($password + array('class' => 'form-control')); ?>
                    </div> 
                </div>


                <div class="form-group">
                    <label for="remember" class="col-md-4 control-label requiredField">
                        <?php echo lang('login_remember_label', 'remember'); ?>
                    </label>
                    <div class ="col-md-6">
                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                    </div> 
                </div>

                <div class="form-group">                
                    <div class ="col-md-offset-4 col-md-6">
                        <?php echo form_submit($login_btn + array('class' => 'form-control')); ?>
                    </div> 
                </div>  
                <div class="row form-group"></div>

                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>

<div class="col-md-3"></div>
<div class="row form-group margin_bottom_admin_img"></div>
