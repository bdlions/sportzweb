<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/wrong_attempt.css">
<?php echo form_open("auth/login", array('class' => 'form-horizontal', 'width' => '300px')); ?>

<div class="row main">
    <div class="col-md-4"></div>
    <div class="col-md-4 wrong_attempt_box">
        <div class="login-box">
            <div class="form-group">
                <div>Login</div>
                <hr></hr>
            </div>
            <div class="form-group">
                <label class="control-label"><?php echo lang('login_identity_label'); ?></label>
                <?php echo form_input($identity + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <label class="control-label"><?php echo lang('login_password_label'); ?></label>
                <?php echo form_input($password + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($login_btn + array('class' => 'btn button-custom pull-right')); ?>
            </div>
            <div class="form-group">
                <?php echo anchor("auth/forget_password", "Forgot your password?", $forget_password); ?>
            </div>
            <?php echo form_close(); ?>
            <?php if($message != ""){ ?><div id="message" class="error-message"><?php echo $message; ?></div><?php }?>
        </div>
    </div>

</div>