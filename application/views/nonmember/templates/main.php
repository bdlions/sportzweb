<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/home.css">
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/twitterslider.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">

<script type="text/javascript">
    $(document).ready(function() {
        var imageList = <?php echo json_encode($image_list) ?>;
        $("#slider").twitterSlideshow({
            imagePath: '<?php echo base_url() ?>resources/images/auth_background/',
            imageList: imageList,
            interval: 6
        });

        $('#next_btn').on('click', function() {
            if ($("#registration-form").valid() === true) {
                $("#login_box").hide();
                $("#left_part").remove();
                $('#step2').removeAttr("class").show(300);
                $("#step1").hide(300);
                Recaptcha.create('<?php echo $public_key ?>',
                        "captcha_div",
                        {
                            theme: "clean",
                            callback: Recaptcha.focus_response_field
                        }
                );
            }
            return false;
        });

        $("#r_captcha_input").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#register_btn').trigger("click");
            }
        });

        $('#register_btn').on('click', function(event) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>auth/captcha_check_client',
                dataType: 'json',
                data: $("#registration-form").serialize(),
                success: function(data) {
                    if (data.is_valid) {
                        $("#registration-form").submit();
                    }
                    else {
                        $("#message").text('<?php echo lang('captcha_error_msg') ?>').attr('class', "error-message");
                        Recaptcha.create('<?php echo $public_key ?>',
                                "captcha_div",
                                {
                                    theme: "clean",
                                    callback: Recaptcha.focus_response_field
                                }
                        );
                    }
                }
            });
            return false;
        });

        // Setup form validation on the #register-form element
        $("#registration-form").validate({
            // Specify the validation rules
            rules: {
//                r_first_name: {
//                    required: true
//                },
//                r_last_name: {
//                    required: true
//                },
                r_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '<?php echo base_url() ?>auth/check_email_client',
                        type: "post"
                    }
                },
                r_password: {
                    required: true,
                    minlength: 5
                },
                r_email_conf: {
                    required: true,
                    equalTo: "#r_email"
                }
            },
            // Specify the validation error messages
            messages: {
//                r_first_name: {
//                    required: "required"
//                },
//                r_last_name: {
//                    required: "required"
//                },
                r_password: {
                    required: "required",
                    minlength: "<?php echo lang('create_user_password_invalid_tooltip_label') ?>"
                },
                r_email: {
                    required: "required",
                    email: "<?php echo lang('create_user_email_invalid_tooltip_label') ?>",
                    remote: "<?php echo lang('create_user_email_duplicate') ?>"
                },
                r_email_conf: {
                    required: "required",
                    equalTo: "<?php echo lang('create_user_confirm_email_match_tooltip_label') ?>",
                }

            }
        });
    });
</script>
<?php echo form_open("auth/login", array('id' => 'registration-form', 'role' => 'form')); ?>
        <div id="step1">
    <div class="container-fluid auth_bg">
        <div class="container"> 
            <div id="slider" ></div>
            <div class="row padding_over_row mg_bottom">
                <div class="col-md-5">
                    <p class="auth_landing_bg_text">
                        A social hub that allows you to connect and share health, sports and fitness information with people.
                        Members have access to a variety of health, sports and fitness applications including diets, personal
                        trainers, blogs, food recipes and news.
                    </p>
                </div>
                <div class="col-md-offset-3 col-md-4">
                    <div class="pagelet_auth">
                        <?php echo form_open("auth/login", array('id' => 'registration-form', 'role' => 'form')); ?>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <span class="sign_up_text">Sign Up</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo form_input($r_email + array('class' => 'form-control input_custom_style')); ?>
                                <!--<input class="form-control input_custom_style" type="text" placeholder="Email">-->
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo form_input($r_email_conf + array('class' => 'form-control input_custom_style')); ?>
                                <!--<input class="form-control input_custom_style" type="text" placeholder="Confirm Email">-->
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <?php echo form_input($r_password + array('class' => 'form-control input_custom_style')); ?>
                                <!--<input class="form-control input_custom_style" type="password" placeholder="Passowrd">-->
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="pull-right">
                                    <?php echo form_input($next_btn + array('class' => 'btn button-custom')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div style="border-bottom: 1px solid #cecece;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <a href="<?php echo base_url(); ?>business_profile.html" class="business_profile_achor_auth">Create a profile for your business.</a>
                            </div>
                        </div>
                        <div id="message"></div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="row form-group"></div>
                    <div class="row form-group"></div>
                    <div class="row form-group"></div>
                </div>
        </div>
    </div>
    </div>
</div>
    <div id="step2" class="security-captcha" >
<div class="container">
        <div class="home-left-tit">
            <div class="home-left-title home-left-title2">Sign Up</div>
        </div>
        <div class="row form-group">
            <div class="col-md-4">
                <!--<input class="form-control security_check_input input_custom_style" type="text" placeholder="First Name">-->
                <?php echo form_input($r_first_name + array('class' => 'form-control security_check_input input_custom_style')); ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-4">
                <?php echo form_input($r_last_name + array('class' => 'form-control security_check_input input_custom_style')); ?>
                <!--<input class="form-control security_check_input input_custom_style" type="text" placeholder="Last Name">-->
            </div>
        </div>
        <div class="heading_medium_thin">
            <?php echo lang('security_check_label'); ?>
        </div>
        <div class="row form-group"></div> 
        <div class="form-group">
            <?php echo lang('please_enter_the_characters_below_label'); ?>
        </div> 
        <div class="form-group" id="captcha_div"></div>
        <div class="form-group">
            <?php echo form_input($register_btn + array('class' => 'btn button-custom')); ?>
        </div>
    </div>
</div>
<div id="message"></div>
<?php echo form_close(); ?>