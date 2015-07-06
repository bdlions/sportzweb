<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/home.css">
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/common_styles.css">
<script type="text/javascript">
    $(document).ready(function () {
        $('#next_btn').on('click', function () {
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

        $("#r_captcha_input").on("keypress", function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#register_btn').trigger("click");
            }
        });

        $('#register_btn').on('click', function (event) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>auth/captcha_check_client',
                dataType: 'json',
                data: $("#registration-form").serialize(),
                success: function (data) {
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
                r_first_name: {
                    required: true
                },
                r_last_name: {
                    required: true
                },
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
                r_first_name: {
                    required: "required"
                },
                r_last_name: {
                    required: "required"
                },
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
<div>
    <ul class="cb-slideshow bg_sliding_ul">
        <li>
            <span>Image 01</span>
        </li>
        <li>
            <span>Image 02</span>
        </li>
        <li>
            <span>Image 03</span>
        </li>
        <li>
            <span>Image 04</span>
        </li>
        <li>
            <span>Image 05</span>
        </li>
        <li>
            <span>Image 06</span>
        </li>
    </ul>
    <div class="container-fluid" style="margin-left: -15px; margin-right: -15px;">
        <div class="row padding_over_row">
            <div class="col-md-offset-1 col-md-10">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <span style="color: #fff;">A social hub that allows you to connect and share health, sports and fitness information with people.
                                    Members have access to a variety of health, sports and fitness applications including diets, personal
                                    trainers, blogs, food recipes and news.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="pagelet_auth">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <span style="color: #89c1f4; font-size: 27px;">Sign Up</span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input class="form-control" type="text" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input class="form-control" type="text" placeholder="Confirm Email">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input class="form-control" type="password" placeholder="Passowrd">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <button class="btn button-custom pull-right">Join Now</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div style="border-bottom: 1px solid #cecece;"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <a href="" class="business_profile_achor_auth">Create a profile for your business.</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>