<div class="top-login">
    <?php echo form_open("auth/login"); ?>
    <ul>
        <li><?php echo lang('login_identity_label'); ?></li>
        <li><?php echo form_input($identity); ?></li>
    </ul>
    <ul>
        <li><?php echo lang('login_password_label'); ?>
            <?php echo anchor("auth/forget_password", "Forgot your password?", $forget_password); ?>
        <li><?php echo form_input($password); ?></li>
    </ul>
    <ul>
        <li><?php echo form_input($login_btn); ?></li>
    </ul>
    <?php echo form_close(); ?>
</div>